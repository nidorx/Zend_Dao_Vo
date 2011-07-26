<?php

/**
 * Nidorx
 *
 * @category  Library
 * @package   Application
 */

/**
 *
 * @category  Library
 * @package   Application
 * @author Alex Rodin <contato@alexrodin.com><nidor.x@gmail.com>
 */
class Nidorx_Application_Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    /**
     * Registrando o namespace Nidorx_
     */
    protected function _initNidorxBootstrap()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Nidorx_');
        Nidorx_Application_Bootstrap::init();
    }


    /**
     * Inicializa todos configs do sistema e registra-os no Zend_Registry
     * uso:
     *      $config = Zend_Registry::get('config');
     *      $config->application->toArray();
     * 
     * @return void
     */
    protected function _initAutoLoadConfig()
    {
        $configPath = APPLICATION_PATH . '/configs';
        $configFileExt = '.ini';
        $configObject = null;

        $handle = opendir($configPath);

        if ($handle) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && ($configName = strstr($file, $configFileExt, true))) {
                    $configFileObject = new Zend_Config_Ini($configPath . '/' . $file);
                    $configObject->{$configName} = $configFileObject;
                }
            }

            closedir($handle);
        }

        //Incluindo o arquivo de config common a todas as applications
        $includePaths = explode(':', get_include_path());
        foreach ($includePaths as $includePath) {
            $path = $includePath . '/Nidorx/config/common.ini';
            if (file_exists($path)) {
                $configFileObject = new Zend_Config_Ini($path);
                $configObject->{'common'} = $configFileObject;
                break;
            }
        }

        Zend_Registry::set('config', $configObject);
    }

    /**
     * Inicializa o logger do Firebug
     */
    protected function _initFirebugLog()
    {
        $logger = new Zend_Log();
        $writerFirebug = new Zend_Log_Writer_Firebug();
        $logger->addWriter($writerFirebug);
        Zend_Registry::set('logger', $logger);
    }

    public function init()
    {

        self::_initAutoLoadConfig();
        self::_initFirebugLog();
    }

    /**
     *
     * Gera o array associativo com o padrão do ResourceType para o Bootstrap.
     *
     * @param string $resourceType
     * @return array
     */
    private function genResourceType($resourceType)
    {
        //Verifica se tem '/'.
        $hasSlash = strstr($resourceType, '/');

        //Se não tiver '/' adiciona '/'para dividir a pasta e adiciona '_' para dividir as classes,
        //Se tiver '/' ele separa as palavras e adicionar $pasta + '/' + $subPasta + '/'
        //e adicionar para nome das classes $nome + s + '_' + $nome + '_'.
        if ($hasSlash == false) {

            //Adiciona um s no final do nome da pasta, se já tiver s não adicionar nada.
            $path = (substr($resourceType, -1) == 's') ? $resourceType : $resourceType . 's';

            //Monta o nome da pasta com '/' e monta o nome da classe com '_'.
            $resourceTypeArray = array(
                'path' => $path . '/',
                'namespace' => ucfirst($resourceType) . '_'
            );
        } else {

            //Separa as palavras onde estiver a barra.
            $path = explode("/", $resourceType);

            //Adiciona um s no final do nome da pasta, se já tiver s não adicionar nada.
            $nameSpace = (substr($path[0], -1) == 's') ? $path[0] : $path[0] . 's';

            //Monta o nome da pasta com as '/' e monta o nome das classes com os '_'.
            $resourceTypeArray = array(
                'path' => $nameSpace . '/' . $path[1] . '/',
                'namespace' => ucfirst($path[0]) . '_' . ucfirst($path[1]) . '_'
            );
        }

        return $resourceTypeArray;
    }

    /**
     * 
     * Gera um array com todos os ResourceTypes gerados pelo
     * self::genResourceType()
     * 
     * @param array $mainResources
     * @param array $subResources
     * @return array
     */
    private function genResourceTypeArray($mainResources, $subResources = null)
    {
        $resourceTypes = array();

        foreach ($mainResources as $resourceType) {
            $resourceTypes[$resourceType] = $this->genResourceType($resourceType);
        }

        if ($subResources) {
            foreach ($subResources as $resourceType) {
                $resourceTypes[$resourceType] = $this->genResourceType($resourceType);
            }
        }

        return $resourceTypes;
    }

    /**
     *
     * Registra todos os módulos e seus resources no autoloader.
     */
    protected function _initAutoload()
    {
        $autoLoader = Zend_Loader_Autoloader::getInstance();

        $applicationConfig = Zend_Registry::get('config')->application->{APPLICATION_ENV};

        $moduleDirectory = $applicationConfig->resources->frontController->moduleDirectory;

        $resourceTypes = $this->genResourceTypeArray($applicationConfig->resources->frontController->modules->resourceTypes);

        foreach ($applicationConfig->resources->frontController->modules as $module) {

            if (!is_object($module)) {

                $resourceLoaderModule = new Zend_Loader_Autoloader_Resource(array(
                            'basePath' => $moduleDirectory . '/' . $module,
                            'namespace' => ucfirst($module . '_'),
                            'resourceTypes' => $resourceTypes
                        ));
            }
        }

        $resourceLoaderModule = new Zend_Loader_Autoloader_Resource(array(
                    'basePath' => APPLICATION_PATH,
                    'namespace' => 'Nidorx_',
                    'resourceTypes' => array(
                        //business
                        'business' => array(
                            'path' => 'business/',
                            'namespace' => 'Business_'
                        ),
                        //Values Objects
                        'vo' => array(
                            'path' => 'vo/',
                            'namespace' => 'Vo_'
                        )
                    )
                ));

        return $autoLoader;
    }

}

