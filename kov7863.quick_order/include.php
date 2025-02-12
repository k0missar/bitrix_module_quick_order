<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/*
 * Здесь размещается код, выполняемый каждый раз при подключении этого модуля
 */

use Bitrix\Main\Loader;

Loader::registerAutoloadClasses(
	'kov7863.quick_order',
	[
		'Kov7863\Quick_Order\QuickOrder' => 'lib/QuickOrder.php',
		'Kov7863\Quick_Order\KoQuickOrderTable' => 'lib/KovQuickOrderTable.php',
	]
);

//require_once __DIR__ . "/functions.php";
//require_once __DIR__ . "/constants.php";
