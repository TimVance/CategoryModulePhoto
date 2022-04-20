<?php

use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use GM\SetCatPhoto\ExampleTable;

Loc::loadMessages(__FILE__);

class gm_setcatphoto extends CModule
{
    public function __construct()
    {
        $arModuleVersion = array();
        
        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }
        
        $this->MODULE_ID = 'gm.setcatphoto';
        $this->MODULE_NAME = Loc::getMessage('GM_SETCATPHOTO_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('GM_SETCATPHOTO_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = Loc::getMessage('GM_SETCATPHOTO_MODULE_PARTNER_NAME');
        $this->PARTNER_URI = 'https://goodmg.ru/';
    }

    public function GetPath($notDocumentRoot=false)
    {
        if($notDocumentRoot)
            return str_ireplace(Application::getDocumentRoot(),'',dirname(__DIR__));
        else
            return dirname(__DIR__);
    }

    function InstallFiles($arParams = array())
    {
        if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath() . '/admin'))
        {
            CopyDirFiles($this->GetPath() . "/install/admin/", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/admin"); //если есть файлы для копирования
        }
        //CopyDirFiles($this->GetPath() . '/install/php_interface/include', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/include', true, true);

        return true;
    }

    function UnInstallFiles()
    {
        if (\Bitrix\Main\IO\Directory::isDirectoryExists($path = $this->GetPath() . '/admin')) {
            DeleteDirFiles($_SERVER["DOCUMENT_ROOT"] . $this->GetPath() . '/install/admin/', $_SERVER["DOCUMENT_ROOT"] . '/bitrix/admin');
        }
        //DeleteDirFiles($this->GetPath() . '/install/php_interface/include', $_SERVER['DOCUMENT_ROOT'] . '/bitrix/php_interface/include');
        return true;
    }

    public function doInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        $this->installDB();
        $this->InstallFiles();
    }

    public function doUninstall()
    {
        $this->uninstallDB();
        ModuleManager::unRegisterModule($this->MODULE_ID);
        $this->UnInstallFiles();
    }

    public function installDB()
    {
        if (Loader::includeModule($this->MODULE_ID))
        {
            //ExampleTable::getEntity()->createDbTable();
        }
    }

    public function uninstallDB()
    {
        if (Loader::includeModule($this->MODULE_ID))
        {
            $connection = Application::getInstance()->getConnection();
            //$connection->dropTable(ExampleTable::getTableName());
        }
    }
}
