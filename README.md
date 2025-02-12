# bitrix_module_quick_order
Модуль bitrix - Быстрый заказ

Для установки скопировать модуль в папку /local/modules/

Возможные проблемы!

1. Если при переходе в админ панели по пункту меню вместо вывода даных будет ошибка 404 значит не корректно скопировался файл отвечающий за их отображение.
Нужно из папк /local/modules/kov7863.quick_order/install/admin скопировать файл kov7863.quick_order_admin.php в папку /bitrix/admin

2. Если не будут скопированы компоненты, то нужно их скопировать из папки /local/modules/kov7863.quick_order/install/components в папку /local/components/kov7863

Стили в компоненты соответствуют шаблону bootstrap_v4, для другого шаблона для компонентов нужно создавать другие шаблоны/стили

За вывод кнопки вызывающий форму отвечает компонент quick_order_button, размещать его необходимо в детальном шаблоне товара, компонент без параметров.
<?php
    $APPLICATION->IncludeComponent(
        "kov7863:quick_order_button",
        "",
        [],
    )
?>

Компонент отвечающий за вывод формы быстрого заказа - quick_order_form. Размещать необходимо в детальном шаблоне товара. В качестве параметра обязательно передать ID товара.
<?php
	$APPLICATION->IncludeComponent(
		"kov7863:quick_order_form",
		"",
		[
			"PRODUCT_ID" => $arResult["ID"] ?? null,
		],
	)
?>
