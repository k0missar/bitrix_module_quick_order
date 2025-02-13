<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CUser $USER */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

\Bitrix\Main\Page\Asset::getInstance()->addCss($templateFolder . '/style.css');
?>
<div class="quick-order-content quick-order-content--hide js-quick-order-content">
	<div class="quick-order-content__wrapper">
		<?php if ($arResult['PRODUCT_ID'] === null): ?>
			<h2>Компонент не получил ID товара. Сообщите администратору.</h2>
		<?php else: ?>
			<form action="<?php echo $arResult['ACTION_FORM'];?>" method="post" class="quick-order-content__form js-quick-order-form">
				<input required name="name" class="form-control" type="text" placeholder="Имя" minlength="2">
				<input required name="phone" class="form-control" type="tel" placeholder="Телефон" pattern="^\+7\d{10}$|^\+7 \d{3} \d{3} \d{2} \d{2}$">
				<input name="mail" class="form-control" type="email" placeholder="E-mail" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$">
				<textarea name="comment" class="form-control"  placeholder="Комментарий к заказу"></textarea>

				<input type="hidden" name="product_id" value="<?php echo $arResult['PRODUCT_ID'];?>">
				<input type="hidden" name="sessid" value="<?php echo bitrix_sessid() ?>">

				<button type="submit" class="btn btn-primary product-item-detail-buy-button">
					Отправить заказ
				</button>
			</form>

			<div class="js-quick-order-content-response"></div>
		<?php endif ?>
		<button class="quick-order-content__close js-quick-order-content-close">X</button>
	</div>
</div>

