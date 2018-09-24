<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Geoip - класс для работы с геоданными
 */

class Geoip extends CI_Controller
{
    /**
     * @var array $link массив с сылками на скачивание архивов
     */
    private $link;

    /**
     * @var array $path массив путей
     */
    private $path;

    /**
     * @var array $archive массив полных путей сохранения архивов
     */
    private $archive;

    /**
     * @var array $files массив с файлами для обработки
     */
    private $files;

    /**
     * @var array массив с результатом проверки необходимости обновления
     */
    private $checkRemote;
    /**
     * @var array массив временных меток последнего изменения файлов на сервере
     */
    private $lastUpdate;

    /**
     * Geoip constructor.
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('geoip_model');
        $this->config->load('geoip', TRUE);
        $this->link = $this->config->item('link', 'geoip');
        $this->path = $this->config->item('path', 'geoip');
        $this->archive = $this->config->item('archive', 'geoip');
        $this->files = $this->config->item('files', 'geoip');
        if (!file_exists($this->path['geoip'])) {
            mkdir($this->path['geoip']);
        }
    }

    /**
     * при заходе без указания метода показываем 404 ошибку
     */
    public function index() {
        show_404();
    }

    /**
     * функция обновления БД
     * @return void
     */
    function update_db() {
        // получаем последнее изменение файлов на удаленном сервере
        $this->filemtimeRemote();
        // проверяем нужно ли обнослять БД
        $this->checkNewVersionDb();
        // если необходимо обновлять обновляем БД
        foreach ($this->checkRemote as $key => $value) {
            if ($value) {
                $this->getArchive($key);
                $this->unpackArchive($key);
                $this->createFilePath($key);
                $this->updateBase($key);
                $str = "Обновлена версия БД ".$key.'<br>';
            } else {
                $str = "Обновление версии БД '.$key.' не требуется<br>";
            }
            echo $str;
        }
    }
    /* TODO сделать поддержку IPv6 */
    /**
     * Получение гео-информации по IP
     * @param string IPv4-адрес
     * @return array|false
     */
    function getRecord($ip) {
        $ipLong = sprintf('%u', ip2long($ip));
        $query_geo = "SELECT * FROM `". $this->tableBase ."` "
            ."INNER JOIN `". $this->tableCities ."` "
            ."ON `". $this->tableBase ."`.`city_id` = `". $this->tableCities ."`.`city_id` "
            ."WHERE `long_ip1` <= '". $ipLong ."' AND `long_ip2` >= '". $ipLong ."' "
            ."LIMIT 1";
        $result_geo = mysqli_query($this->link, $query_geo)
        or trigger_error(mysqli_error($this->link)." in ".$query_geo );
        if (mysqli_num_rows($result_geo) == 1) {
            $result = mysqli_fetch_assoc($result_geo);
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * сравнение локальной версии БД с БД на удаленом сервере
     *
     * @return void
     */
    private function checkNewVersionDb() {
        $fLastTime = $this->path['geoip'] . '/last_update.txt';
        $cLastTime = (file_exists($fLastTime))?file_get_contents($fLastTime):false;
        if ($cLastTime === false) {
            $this->checkRemote['country'] = true;
            $this->checkRemote['city'] = true;
        } else {
            $localLastTime = json_decode($cLastTime, true);
            foreach ($localLastTime as $key => $value) {
                if ($this->lastUpdate[$key] == 0 || $this->lastUpdate[$key] == $localLastTime[$key]) {
                    $this->checkRemote[$key] = false;
                } else {
                    $this->checkRemote[$key] = true;
                }
            }
        }
    }

    /**
     * функция получения таймштампа последнего изменения файла на удаленном сервере
     *
     * @return void
     */
    private function filemtimeRemote() {
        $ret = array();
        foreach ($this->link as $key => $link) {
            $url = parse_url($link);
            $handle = fsockopen('ssl://'.$url['host'], 443);
            if (!$handle) {
                $ret[$key] = 0;
            }
            fputs($handle, "GET ".$url['path']." HTTP/1.1\r\nHost: ".$url['host']."\r\n\r\n");
            while (!feof($handle)) {
                $line = fgets($handle, 1024);
                if (!trim($line)) { break; }
                $col = strpos($line, ':');
                if ($col !== false) {
                    $header = trim(substr($line, 0, $col));
                    $value = trim(substr($line, $col+1));
                    if (strtolower($header) == 'last-modified') {
                        $ret[$key] = strtotime($value);
                        break;
                    }
                }
            }
            fclose($handle);
        }
        $this->lastUpdate = $ret;
    }

    /**
     * функция получения архива
     *
     * @param string $key
     *
     * @return void
     */
    private function getArchive($key) {
        if (!file_exists($this->path[$key])) {
            mkdir($this->path[$key]);
        }
        $curl = curl_init($this->link[$key]);
        $fp = fopen($this->archive[$key], 'w');
        curl_setopt($curl, CURLOPT_FILE, $fp);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_exec($curl);
        curl_close($curl);
        fflush($fp);
        fclose($fp);
    }

    /**
     * функция распаковки архива
     *
     * @param string $key
     *
     * @return bool
     */
    private function unpackArchive($key) {
        $zip = new ZipArchive;
        if ($zip->open($this->archive[$key]) === TRUE) {
            $zip->extractTo($this->path[$key]);
            $zip->close();
            unlink($this->archive[$key]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * функция генерации путей файлов
     *
     * @param $key
     *
     * @return void
     */
    private function createFilePath($key) {
        $files = array();
        foreach ($this->files[$key] as $file) {
            $pName = pathinfo($this->archive[$key], PATHINFO_FILENAME);
            $files[] = $this->path[$key] . $pName . '_' .
                       date('Ymd',
                           strtotime('tuesday this week', $this->lastUpdate[$key]
                       )) . DS . $file;
            }
        $this->files[$key] = $files;

    }

    /**
     * запуск обновления БД
     *
     * @param string $key
     *
     * @return void
     */
    private function updateBase($key) {
        switch ($key) {
            case 'country':
                $this->updateCountry();
                break;
            case 'city':
                $this->updateCity();
                break;
        }
    }

    private function updateCountry() {
        set_time_limit(0);
        list($blocksV4, $blocksV6, $country_en, $country_ru) = $this->files['country'];

        // обрабатываем файл стран на английском языке
        $file = file($country_en, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        unset($file[0]);
        // geoname_id,locale_code,continent_code,continent_name,country_iso_code,country_name,is_in_european_union
        foreach ($file as $row) {
            $out = array();
            list($out['geoname_id'], $out['lang'], $out['continent_code'],
                 $out['continent_name'], $out['country_iso_code'],
                 $out['country_name'], $out['is_in_european_union']) = explode(",", $row);
            $this->geoip_model->set_country($out);
        }

        // обрабатываем файл стран на русском языке
        $file = file($country_ru, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        unset($file[0]);
        // geoname_id, locale_code, continent_code, continent_name    , country_iso_code, country_name                   , is_in_european_union
        // 7626844   , ru         , NA            , "Северная Америка", BQ              , "Бонайре, Синт-Эстатиус и Саба", 0
        $pattern = '#(\d+)\s+(.*?)\t+(.*?)\t+(.*?)\t+(.*?)\s+(.*)#';
        foreach ($file as $row) {
            $out = array();
            list($out['geoname_id'], $out['lang'], $out['continent_code'],
                $out['continent_name'], $out['country_iso_code'],
                $out['country_name'], $out['is_in_european_union']) = explode(",", $row);
            $this->geoip_model->set_country($out);
        }

    }
    private function updateCity() {
        set_time_limit(0);
        list($blocksV4, $blocksV6, $city_en, $city_ru) = $this->files['country'];

        /*mysqli_query($this->link, "TRUNCATE TABLE `". $this->tableCities ."`"); // очищаем таблицу перед импортом актуальных данных
        $file = file($this->dirName .'/'. $this->citiesFile);
        $pattern = '#(\d+)\s+(.*?)\t+(.*?)\t+(.*?)\t+(.*?)\s+(.*)#';
        foreach ($file as $row) {
            $out = [];
            $row = iconv('windows-1251', 'utf-8', $row);
            if (preg_match($pattern, $row, $out)) {
                mysqli_query($this->link, "INSERT INTO `". $this->tableCities ."` "
                                        ."(`city_id`, `city`, `region`, `district`, `lat`, `lng`) "
                                        ."VALUES('$out[1]', '$out[2]', '$out[3]', '$out[4]', '$out[5]', '$out[6]')");
            }
        }*/
    }

    private function matchCIDR($addr, $cidr) {
        list($ip, $mask) = explode('/', $cidr);
        $mask = 0xffffffff << (32 - $mask);
        return ((ip2long($addr) & $mask) == (ip2long($ip) & $mask));
    }
}