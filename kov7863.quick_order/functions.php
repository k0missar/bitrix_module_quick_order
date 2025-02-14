<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * Здесь можно объявлять собственные функции
 */


if (!function_exists('showMessage')) {
	/**
	 * @var string $message - сообщение успеха или ошибки
	 * @var bool $success - true если успех, false если ошибка
	 */
	function showMessage(string $message, bool $success = false) : void
	{
		$response = $success ? ['success' => $message] : ['errors' => $message];
		echo json_encode($response, JSON_UNESCAPED_UNICODE);
		exit;
	}
}
