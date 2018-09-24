<?php defined('BASEPATH') OR exit('No direct script access allowed');

// ссылки на скачивание архива БД
$config['link']['country'] = 'https://geolite.maxmind.com/download/geoip/database/GeoLite2-Country-CSV.zip';
$config['link']['city'] = 'https://geolite.maxmind.com/download/geoip/database/GeoLite2-City-CSV.zip';

// таблицы БД
$config['tables']['continent'] = 'geo_continent';
$config['tables']['country']   = 'geo_country';
$config['tables']['region']    = 'geo_region';
$config['tables']['city']      = 'geo_city';
$config['tables']['geoipv4']   = 'geo_ipv4';
$config['tables']['geoipv6']   = 'geo_ipv6';

// пути сохранения файлов
$config['path']['geoip']   = SERVERROOT . DS . 'upload' . DS . 'geoip' . DS;
$config['path']['country'] = SERVERROOT . DS . 'upload' . DS . 'geoip' . DS . 'country' . DS;
$config['path']['city']    = SERVERROOT . DS . 'upload' . DS . 'geoip' . DS . 'city' . DS;

// имя файлов архивов
$config['archive']['country'] = SERVERROOT . DS . 'upload' . DS . 'geoip' . DS . 'country' . DS . 'GeoLite2-Country-CSV.zip';
$config['archive']['city']    = SERVERROOT . DS . 'upload' . DS . 'geoip' . DS . 'city' . DS . 'GeoLite2-City-CSV.zip';

// файлы для распаковки
$config['files']['country'] = array(
    'GeoLite2-Country-Blocks-IPv4.csv',
    'GeoLite2-Country-Blocks-IPv6.csv',
    'GeoLite2-Country-Locations-en.csv',
    'GeoLite2-Country-Locations-ru.csv'
);
$config['files']['city'] = array(
    'GeoLite2-City-Blocks-IPv4.csv',
    'GeoLite2-City-Blocks-IPv6.csv',
    'GeoLite2-City-Locations-en.csv',
    'GeoLite2-City-Locations-ru.csv'
);