<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Автодеплой из битбакета
 *
 * Class Deploy
 */
class Webhook extends CI_Controller
{
    /**
    * Адрес файла лога
    *
    * @var string
    */
    private $_logfile = 'deploy.log';

    /**
    * Адрес файла для отслеживания incron
    *
    * @var string
    */
    private $_runfile = 'deploy_run.log';

    private $_whKey;
    private $_needBranch;

    public function __construct() {
        parent::__construct();
        $this->config->load('webhook', TRUE);
        $this->set_log_file($this->config->item('log_file', 'webhook'));
        $this->set_run_file($this->config->item('run_file', 'webhook'));
        $this->_whKey = $this->config->item('whKey', 'webhook');
        $this->_needBranch = $this->config->item('needBranch', 'webhook');
        $this->log('Attempting deployment...');
    }

    /**
    * Логирование происходящего
    *
    * @param $somecontent
    * @param string $type
    */
    private function log($somecontent, $type = 'INFO') {
        $handle      = fopen($this->_logfile, 'a+');
        $somecontent = date('Y-m-d H:i:s ') . ' [' . $type . ']: ' . $somecontent . "\n";
        fwrite($handle, $somecontent);
        fclose($handle);
    }

    /**
    * Установка адрес лог файла
    *
    * @param string $path
    */
    public function set_log_file($path = 'deploy.log') {
        $this->_logfile = $path;
    }

    public function set_run_file($path = 'deploy.log') {
        $this->_runfile = $path;
    }

    /**
    * Выполнение необходимого для pull запроса
    */
    public function execute() {
        try {
            // Создаем файл который отслеживается
            $handle = fopen($this->_runfile, 'w+');
            $somecontent = date('Y-m-d H:i:s ') . "Run deploy... \n";
            fwrite($handle, $somecontent);
            fclose($handle);
        } catch (Exception $e) {
            $this->log($e, 'ERROR');
        }
    }
    public function deploy($wh) {
        $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
        // Валидация ключа запроса
        if ($wh !== $this->_whKey) {
            header($protocol . ' 400 Bad Request');
            die('invalid validate key.');
        }

        // Проверяем, чтобы ветка была правильной

        $body = json_decode($this->input->raw_input_stream);

        if (!$body) {
            header($protocol . ' 400 Bad Request');
            die('missing payload');
        }

        $push_branch = $body->push->changes[count($body->push->changes) - 1]->new->name;

        if ($push_branch != $this->_needBranch) {
            header($protocol . ' 200 OK');
            die('not required branch.');
        }
        $this->execute();
    }
    public function index() {}
}