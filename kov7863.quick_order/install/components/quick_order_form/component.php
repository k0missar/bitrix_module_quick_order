<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Application;
$session = Application::getInstance()->getSession();

$arResult['PRODUCT_ID'] = $arParams['PRODUCT_ID'];

$arResult['ACTION_FORM'] = $componentPath . '/action_form.php';

$session->set('SITE_ID', $arParams['SITE_ID'] ?? null);
$session->set('EVENT_TYPE', $arParams['EVENT_TYPE'] ?? null);

$this->IncludeComponentTemplate();
