<?php

namespace Kov7863\Quick_Order;

use Bitrix\Main\Type;

use Kov7863\Quick_Order\KovQuickOrderTable;

class QuickOrder
{
	private static $cachedData = null;

	/**
	 * Получает данные быстрых заказов с кэшированием.
	 *
	 * @return array
	 */
	public static function getQuickOrderData(): array
	{
		if (self::$cachedData === null) {
			$result = KovQuickOrderTable::getList([
				'select' => ['ID', 'NAME', 'PHONE', 'EMAIL', 'COMMENT', 'DATE_CREATE', 'STATUS', 'PRODUCT_ID'],
			]);

			// fetchAll() сразу возвращает массив
			self::$cachedData = $result->fetchAll();
		}

		return self::$cachedData;
	}

	/**
	 * Сброс кэша
	 */
	public static function resetCache(): void
	{
		self::$cachedData = null;
	}

	/**
	 * Добавление данных
	 * string $name - Имя клиента
	 * string $phone - Номер телефона клиента
	 * string $email - Электронная почта клиента
	 * string $comment - Комментарий к заказу клиента
	 * string $product_id - ID товара
	 * @return int|bool
	 */
	public static function setQuickOrderProduct($name, $phone, $email, $comment, $product_id): int|bool
	{
		$result = KovQuickOrderTable::add([
			'NAME' => $name,
			'PHONE' => $phone,
			'EMAIL' => $email,
			'COMMENT' => $comment,
			'DATE_CREATE' => new Type\DateTime(),
			'STATUS' => 'new',
			'PRODUCT_ID' => $product_id,
		]);
		if ($result->isSuccess())
		{
			return $result->getId();
		} else {
			return false;
		}
	}
}
