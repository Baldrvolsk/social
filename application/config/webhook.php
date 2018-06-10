<?php
/**
 * Created by PhpStorm.
 * User: Baldr
 * Date: 10.06.2018
 * Time: 22:03
 */

// Проверочный ключ
$whKey = "V6A9BBND5PiSHf9ExuIUhtnC0n6oE8Bd";
// ветка которая отслеживается
$needBranch = 'dev';
// полный путь до лог-файла включая имя файла
$log_file = APPPATH.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'deploy.log';

$run_file = APPPATH.DIRECTORY_SEPARATOR.'logs'.DIRECTORY_SEPARATOR.'deploy_run.txt';