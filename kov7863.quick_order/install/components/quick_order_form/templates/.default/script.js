document.addEventListener('DOMContentLoaded', ()=> {
	//Обработка и отправка формы без перезагрузки
	const quickOrderForm = document.querySelector('.js-quick-order-form')
	const quickOrderContentJ = document.querySelector('.js-quick-order-content')

	if (quickOrderContentJ && quickOrderForm) {
		quickOrderForm.addEventListener('submit', function (event) {
			event.preventDefault();

			const formData = new FormData(quickOrderForm)
			const quickOrderContentResponse = document.querySelector('.js-quick-order-content-response')

			fetch(quickOrderForm.action, {
				method: 'POST',
				body: formData,
			})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						quickOrderContentResponse.innerText = data.success
						quickOrderContentResponse.classList.add('alert', 'alert-success', 'quick-order-content__response')

						quickOrderForm.reset();
					} else {
						quickOrderContentResponse.innerText = data.errors
						quickOrderContentResponse.classList.add('alert', 'alert-danger', 'quick-order-content__response')
					}
				})
				.catch(error => {
					console.error('Ошибка:', error);
					quickOrderContentResponse.innerText = 'Произошла ошибка при отправке формы.'
					quickOrderContentResponse.classList.add('alert', 'alert-danger', 'quick-order-content__response')
				});
		});

		// Скрытие формы
		document.addEventListener('click', event=> {
			const target = event.target

			if (target.closest('.js-quick-order-button')) {
				return;
			}

			if (!target.closest('.js-quick-order-content') || target.closest('.js-quick-order-content-close')) {
				quickOrderContentJ.classList.add('quick-order-content--hide')
			}
		})
	}
})