<?php

namespace Kov7863\Quick_Order;

use Bitrix\Main\Entity;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\ORM\Fields;
use Bitrix\Main\ORM\Fields\Validators;

class KovQuickOrderTable extends Entity\DataManager
{
	public static function getTableName()
	{
		return 'kov_quick_order';
	}

	public static function getMap()
	{
		return [
			new Entity\IntegerField('ID', [
				'primary' => true,
				'autocomplete' => true,
			]),

			new Entity\StringField('NAME', [
				'required' => true,
				'validation' => function () {
					return [
						new Validators\LengthValidator(null, 255),
					];
				},
			]),

			new Entity\StringField('PHONE', [
				'required' => true,
				'validation' => function () {
					return [
						new Validators\LengthValidator(null, 20),
					];
				},
			]),

			new Entity\StringField('EMAIL', [
				'validation' => function () {
					return [
						new Validators\LengthValidator(null, 255),
					];
				},
			]),

			new Entity\TextField('COMMENT'),

			new Entity\DatetimeField('DATE_CREATE', [
				'default_value' => function() {
					return new DateTime();
				},
			]),

			new Entity\EnumField('STATUS', [
				'values' => ['new', 'processed'],
				'default_value' => 'new',
			]),

			new Entity\IntegerField('PRODUCT_ID', [
				'required' => true,
			]),
		];
	}
}
