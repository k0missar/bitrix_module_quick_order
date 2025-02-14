<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php';
use Bitrix\Main\Loader;
use Kov7863\Quick_Order\QuickOrder;

Loader::includeModule("kov7863.quick_order");

$arResult = QuickOrder::getQuickOrderData();

$statusFilter = $_GET['status'] ?? '';
$dateFrom = $_GET['date_from'] ?? '';
$dateTo = $_GET['date_to'] ?? '';

$dateFromObj = $dateFrom ? DateTime::createFromFormat('Y-m-d', $dateFrom) : null;
$dateToObj = $dateTo ? DateTime::createFromFormat('Y-m-d', $dateTo) : null;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_after.php'; ?>

<div class="quick-order-admin">
	<form method="GET" class="quick-order-admin__filter">
		<label>
			Статус:
			<select name="status">
				<option value="">Все</option>
				<option value="new" <?php echo ($_GET['status'] ?? '') === 'new' ? 'selected' : ''; ?>>Новый</option>
				<option value="processed" <?php echo ($_GET['status'] ?? '') === 'processed' ? 'selected' : ''; ?>>Обработано</option>
			</select>
		</label>

		<label>
			Дата от:
			<input type="date" name="date_from" value="<?php echo htmlspecialchars($_GET['date_from'] ?? ''); ?>">
		</label>

		<label>
			Дата до:
			<input type="date" name="date_to" value="<?php echo htmlspecialchars($_GET['date_to'] ?? ''); ?>">
		</label>

		<button type="submit">Фильтровать</button>
		<a href="?">Сбросить</a>
	</form>

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
	<?php foreach ($arResult as $item):
		if ($statusFilter && $statusFilter !== $item['STATUS']) :
			continue;
		endif;
		$orderDateObj = DateTime::createFromFormat('Y-m-d', $item['DATE_CREATE']->format("Y-m-d"));

		if (($dateFromObj && $orderDateObj < $dateFromObj) || ($dateToObj && $orderDateObj > $dateToObj)) :
			continue;
		endif;
	?>
		<div class="quick-order-admin__row">
			<div><?php echo $item['ID'];?></div>
			<div><?php echo $item['NAME'];?></div>
			<div><?php echo $item['PHONE'];?></div>
			<div><?php echo $item['EMAIL'];?></div>
			<div><?php echo $item['COMMENT'];?></div>
			<div><?php echo $item['DATE_CREATE']->format("Y-m-d");?></div>
			<div>
				<form class="quick-order-admin__form-<?php echo $item['ID'];?> js-quick-order-admin-form" method="POST" action="<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', __DIR__) . '/update_status.php'?>">
					<input type="hidden" name="order_id" value="<?php echo $item['ID']; ?>">
					<input type="hidden" name="sessid" value="<?php echo bitrix_sessid() ?>">
					<select name="status">
						<option value="new" <?php echo ($item['STATUS'] == 'new') ? 'selected' : ''; ?>>Новый</option>
						<option value="processed" <?php echo ($item['STATUS'] == 'processed') ? 'selected' : ''; ?>>Обработано</option>
					</select>
				</form>
			</div>
			<div><?php echo $item['PRODUCT_ID'];?></div>
		</div>
	<?php endforeach; ?>
</div>

<style>
	.quick-order-admin__filter {
		margin-bottom: 15px;
	}
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

<script>
	document.addEventListener('DOMContentLoaded', ()=> {
		const quickOrderAdmin = document.querySelector('.quick-order-admin')
		if (quickOrderAdmin) {
			quickOrderAdmin.addEventListener('change', event => {
				const target = event.target
				if (target.tagName.toLowerCase() === 'select' && target.closest('.js-quick-order-admin-form')) {
					const form = target.closest('.js-quick-order-admin-form')

					const formData = new FormData(form)
					fetch(form.action, {
						method: 'POST',
						body: formData,
					})
						.then(response => response.json())
						.then(data => {
							if (data.success) {
								alert(data.success)
							} else {
								alert(data.errors)
							}
						})
						.catch(error => {
							console.error('Ошибка:', error);
						})
				}
			})
		}
	})
</script>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_admin.php';
