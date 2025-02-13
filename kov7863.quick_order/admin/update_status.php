<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

use Bitrix\Main\Loader;
use Kov7863\Quick_Order\QuickOrder;

header('Content-Type: application/json; charset=utf-8');

if (!empty($_POST['order_id']) && !empty($_POST['status']))
{
	$orderId = (int)$_POST['order_id'];
	$status = $_POST['status'];

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
