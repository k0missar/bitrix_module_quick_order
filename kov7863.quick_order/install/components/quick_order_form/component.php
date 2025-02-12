<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arResult['PRODUCT_ID'] = $arParams['PRODUCT_ID'];

$arResult['ACTION_FORM'] = $componentPath . '/action_form.php';

$this->IncludeComponentTemplate();
