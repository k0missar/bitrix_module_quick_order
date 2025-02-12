<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class kov7863_quick_order extends CModule
{
	/**
	 * @return string
	 */
	public static function getModuleId()
	{
		return basename(dirname(__DIR__));
	}

	public function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__) . "/version.php");
		$this->MODULE_ID = self::getModuleId();
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = Loc::getMessage("QUICK_ORDER_MODULE_NAME");
		$this->MODULE_DESCRIPTION = Loc::getMessage("QUICK_ORDER_CUSTOM_MODULE_DESC");

		$this->PARTNER_NAME = Loc::getMessage("QUICK_ORDER_CUSTOM_PARTNER_NAME");
		$this->PARTNER_URI = Loc::getMessage("QUICK_ORDER_CUSTOM_PARTNER_URI");
	}

	function InstallFiles($arParams = array()) {
		CopyDirFiles(
			$_SERVER['DOCUMENT_ROOT'].'/local/modules/kov7863.quick_order/install/admin',
			$_SERVER['DOCUMENT_ROOT'].'/bitrix/admin',
			true,
			true
		);

		CopyDirFiles(
			$_SERVER['DOCUMENT_ROOT'].'/local/modules/kov7863.quick_order/install/components',
			$_SERVER['DOCUMENT_ROOT'].'/local/components/kov7863',
			true,
			true
		);
		return true;
	}

	public function doInstall()
	{
		global $DB;

		try
		{
			Main\ModuleManager::registerModule($this->MODULE_ID);

			// Создание таблицы CORE_CONTACT
			$sql = "
				CREATE TABLE IF NOT EXISTS kov_quick_order (
					ID INT AUTO_INCREMENT PRIMARY KEY,
					NAME VARCHAR(255) NOT NULL,
					PHONE VARCHAR(20) NOT NULL,
					EMAIL VARCHAR(255),
					COMMENT TEXT,
					DATE_CREATE DATETIME DEFAULT CURRENT_TIMESTAMP,
					STATUS ENUM('new', 'processed') DEFAULT 'new',
					PRODUCT_ID INT
				);
			";
			if (!$DB->Query($sql, true)) {
				throw new Exception("Ошибка создания таблицы kov_quick_order");
			}
		}
		catch (Exception $e)
		{
			global $APPLICATION;
			$APPLICATION->ThrowException($e->getMessage());

			return false;
		}

		return true;
	}

	public function doUninstall()
	{
		global $DB;

		try
		{
			// Удаление таблицы CORE_CONTACT
			$sql = "DROP TABLE IF EXISTS kov_quick_order;";
			if (!$DB->Query($sql, true)) {
				throw new Exception("Ошибка удаления таблицы kov_quick_order");
			}

			Main\ModuleManager::unRegisterModule($this->MODULE_ID);
		}
		catch (Exception $e)
		{
			global $APPLICATION;
			$APPLICATION->ThrowException($e->getMessage());

			return false;
		}

		return true;
	}

}