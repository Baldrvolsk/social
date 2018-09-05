<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * функция форматирования даты с учетом локали
 *
 * @param int    $t      Таймштамп
 * @param string $locale двухбуквенный код локили en|ru
 * @param string $format формат вывода даты для функции strftime()
 *
 * @return string
 */
function date_to_str($format, $locale, $t = null) {
    // если не указан таймштамп берем текущее время
    if ($t === null) $t = time();
    // если формат передан в виде пустой строки применим д месяц год
    if ($format === '') $format = '%e&nbsp;%bg&nbsp;%Y';
    // выбираем локаль вывода
    $l = '';
    switch ($locale) {
        case 'en':
            $l = array('',
                       'english',
                       'eng',
                       'english-uk',
                       'uk',
                       'american',
                       'american english',
                       'american-english',
                       'english-american',
                       'english-us',
                       'english-usa',
                       'enu',
                       'us',
                       'usa'
            );
            $format = preg_replace(array("~\%bf~", "~\%bs~"), array('%B', '%b'), $format);
            break;
        case 'ru':
            $l = array('', 'ru_RU', 'ru_RU.UTF-8', 'ru', 'rus', 'russian');
            // если русский язык то заменяем месяц на родительный падеж
            $m_f = explode("|", '|января|февраля|марта|апреля|мая|июня|июля|августа|сентября|октября|ноября|декабря');
            $m_s = explode("|", '|янв|фев|мар|апр|мая|июня|июля|авг|сен|окт|ноя|дек');
            $format = preg_replace(array("~\%bf~", "~\%bs~"),
                array($m_f[date('n', $t)], $m_s[date('n', $t)]),
                $format);
            break;
    }
    setlocale(LC_ALL, $l);
    // форматируем дату
    $time = strftime($format, $t);
    // если работаем из под винды то конвертируем строку в utf-8
    /*if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $time = iconv('Windows-1251', 'UTF-8', $time);
    }*/
    return $time;
}

/**
 * функция выбора правильной формы слова следующего за числом
 * пример использования параметра $words:
 *  1. 'кенгуру', // не склоняется
 *  2. 'hour%s', // мн. ч. всегда одинаковое
 *  3. 'час%а%ов', // ед. ч. == основа
 *  4. 'комментари%й%я%ев', // ух, сколько вариантов!
 *  5. '%ребенок%ребенка%детей' // начинается с %, берем "как есть"
 * @param int $num      число
 * @param string $words набор склонений, см. пример
 *
 * @return string
 */
function decl_a_num($num, $words) {
    if (is_string($words)) {
        $parts = explode("%", $words);
        $r = array_shift($parts);
        if ($r == '') {
            $words = $parts;
            if (!isset($words[2])) {
                $words[2] = $parts[1];
            }
        } else {
            $count_parts = count($parts);
            // 1.
            $words = array($r, $r, $r);
            switch ($count_parts) {
                case 1:
                    // 2.
                    $words[1] .= $parts[0];
                    $words[2] .= $parts[0];
                    break;
                case 2:
                    // 3.
                    $words[1] .= $parts[0];
                    $words[2] .= $parts[1];
                    break;
                case 3:
                    // 4.
                    $words[0] .= $parts[0];
                    $words[1] .= $parts[1];
                    $words[2] .= $parts[2];
                    break;
            }
        }
    }
    $num = $num % 100;
    if ($num > 19) {
        $num = $num % 10;
    }
    switch ($num) {
        case 1:
            return ($words[0]);
        case 2:
        case 3:
        case 4:
            return ($words[1]);
        default:
            return ($words[2]);
    }
}