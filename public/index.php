<?php

/**
 *
 * Arquivo de inicialização da Application
 *
 * @category  Public
 */
//Atalho para o separador de diretório
defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('APPLICATION_PATH')
        || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

defined('APPLICATION_INI')
        || define('APPLICATION_INI', APPLICATION_PATH . '/configs/application.ini');

defined('APPLICATION_ENV')
        || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Certificando que as bibliotecas humrum estão no IncludePath
set_include_path(implode(PATH_SEPARATOR, array(
            realpath(APPLICATION_PATH . '/library'),
            get_include_path(),
        )));
//Path para os arquivos de linguagem
defined('LANGUAGES_PATH')
        || define('LANGUAGES_PATH', realpath(APPLICATION_PATH . '/languages'));
require_once 'Zend/Application.php';



$application = new Zend_Application(
                APPLICATION_ENV, APPLICATION_INI
);


$application->bootstrap()
        ->run();