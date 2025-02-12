<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php';
use Bitrix\Main\Loader;
use Kov7863\Quick_Order\QuickOrder;

Loader::includeModule("kov7863.quick_order");

$arResult = QuickOrder::getQuickOrderData();

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_after.php'; ?>

<div class="quick-order-admin">
	<div class="quick-order-admin__row">
		<div>ID</div>
		<div>Имя клиента</div>
		<div>Телефон</div>
		<div>E-mail</div>
		<div>Комментарий</div>
		<div>Дата заказа</div>
		<div>Статус</div>
		<div>Товар</div>
	</div>
	<?php foreach ($arResult as $item): ?>
		<div class="quick-order-admin__row">
			<div><?php echo $item['ID'];?></div>
			<div><?php echo $item['NAME'];?></div>
			<div><?php echo $item['PHONE'];?></div>
			<div><?php echo $item['EMAIL'];?></div>
			<div><?php echo $item['COMMENT'];?></div>
			<div><?php echo $item['DATE_CREATE']->format("Y-m-d");?></div>
			<div><?php echo $item['STATUS'];?></div>
			<div><?php echo $item['PRODUCT_ID'];?></div>
		</div>
	<?php endforeach; ?>
</div>

<style>
	.quick-order-admin__row {
		display: grid;
		grid-template-columns: .5fr repeat(7, 1fr);
	}
	.quick-order-admin__row div {
		padding: 15px 30px;
		background-color: #ffffff;
		text-align: center;
	}
</style>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_admin.php';
