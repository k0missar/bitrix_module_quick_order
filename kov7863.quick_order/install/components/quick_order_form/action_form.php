<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
use Kov7863\Quick_Order\QuickOrder;

header('Content-Type: application/json; charset=utf-8');

if (!check_bitrix_sessid()) {
	$response["errors"][] = "Ошибка сессии";
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
	exit;
}

if (!Loader::includeModule("kov7863.quick_order"))
{
	$response["errors"][] = "Не подключен модуль Быстрый заказ";
	echo json_encode($response, JSON_UNESCAPED_UNICODE);
	exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if (!empty($_POST))
	{
		if (empty($_POST["name"]))
		{
			$response["errors"] = "Не заполнено имя";
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			exit;
		}
		if (empty($_POST["phone"]))
		{
			$response["errors"] = "Не заполнен телефон";
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			exit;
		}
		if (empty($_POST["product_id"]))
		{
			$response["errors"] = "Ошибка заполнения товара. Сообщите администратору!";
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			exit;
		}

		$name = htmlspecialcharsbx($_POST["name"]);
		$phone = htmlspecialcharsbx($_POST["phone"]);

		$product_id = htmlspecialcharsbx($_POST["product_id"]);

		$mail = htmlspecialcharsbx($_POST["mail"]) ?? 'Не заполнен';
		$comment = htmlspecialcharsbx($_POST["comment"]) ?? '';

		if (QuickOrder::setQuickOrderProduct($name, $phone, $mail, $comment, $product_id))
		{
			$response["success"] = "Спасибо за заказ!";
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
		} else {
			$response["errors"] = "Ошибка добавления заказа!";
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
		}
	}
}

