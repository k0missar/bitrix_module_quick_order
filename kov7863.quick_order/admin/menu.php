<?php
defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();
/** @global CMain $APPLICATION */

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

if ($APPLICATION->GetGroupRight('kov7863.quick_order')<='D')
{
	return false;
}

return [
	'parent_menu' => 'global_menu_settings',
	'sort' => 100,
	'text' => Loc::getMessage('QUICK_ORDER'),
	'title' => Loc::getMessage('QUICK_ORDER_TITLE'),
	"url" => "kov7863.quick_order_admin.php",
	'icon' => 'currency_menu_icon',
	'page_icon' => 'currency_page_icon',
	'items_id' => 'menu_kov7863_quick_order',
	'items' => [],
];
