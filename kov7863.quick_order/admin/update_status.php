<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Loader;
use Kov7863\Quick_Order\QuickOrder;

header('Content-Type: application/json; charset=utf-8');

$http_host = $_SERVER['HTTP_HOST'];
$referer = parse_url($_SERVER['HTTP_REFERER'] ?? '', PHP_URL_HOST);
if (!empty($referer) && $referer !== $http_host) {
	$response["errors"] = "Ошибка: недостоверный домен. (REFERER: $referer, HOST: $http_host)";
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
	exit;
}

if (!check_bitrix_sessid()) {
	$response["errors"] = "Ошибка сессии";
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
	exit;
}

if (!empty($_POST['order_id']) && !empty($_POST['status']))
{
	$orderId = (int)htmlspecialcharsbx($_POST['order_id']);
	$status = htmlspecialcharsbx($_POST['status']);

	if (Loader::includeModule('kov7863.quick_order'))
	{
		$updateResult = QuickOrder::updateOrderStatus($orderId, $status);

		if ($updateResult)
		{
			$response["success"] = "Статус обновлен!";
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			exit;
		}
		else {
			$response["errors"] = "Ошибка обновления. Сообщите администратору!";
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			exit;
		}
	}
	else {
		$response["errors"] = "Модуль не подключен. Сообщите администратору!";
		echo json_encode($response, JSON_UNESCAPED_UNICODE);
		exit;
	}
}
else
{
	$response["errors"] = "Нет данных для обновления";
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
	exit;
}
