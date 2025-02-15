document.addEventListener('DOMContentLoaded', () => {
	// Получаем элементы
	const quickOrderForm = document.querySelector('.js-quick-order-form')
	const quickOrderContent = document.querySelector('.js-quick-order-content')
	const quickOrderResponse = document.querySelector('.js-quick-order-content-response')

	if (!quickOrderContent || !quickOrderForm) return

	function showModal() {
		quickOrderContent.classList.remove('quick-order-content--hide')
		quickOrderContent.classList.add('quick-order-content--show')
	}

	function hideModal() {
		quickOrderContent.classList.remove('quick-order-content--show')
		quickOrderContent.classList.add('quick-order-content--hide')
	}

	// Обработка формы
	quickOrderForm.addEventListener('submit', function (event) {
		event.preventDefault()
		const formData = new FormData(quickOrderForm)

		const name = formData.get('name')
		const phone = formData.get('phone')
		const mail = formData.get('mail')

		quickOrderResponse.innerText = ''
		quickOrderResponse.classList.remove('alert-success', 'alert-danger')

		if (name.length < 2) {
			quickOrderResponse.innerText = 'Имя слишком короткое'
			quickOrderResponse.classList.add('alert', 'alert-danger')
			return
		}

		let phonePattern = /^\+7\d{10}$|^\+7 \d{3} \d{3} \d{2} \d{2}$/
		if (!phonePattern.test(phone)) {
			quickOrderResponse.innerText = 'Телефон должен быть в формате +7XXXXXXXXXX или +7 XXX XXX XX XX.'
			quickOrderResponse.classList.add('alert', 'alert-danger')
			return
		}

		let mailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
		if (mail.length > 0 && !mailPattern.test(mail)) {
			quickOrderResponse.innerText = 'Неверный формат электронной почты'
			quickOrderResponse.classList.add('alert', 'alert-danger')
			return
		}

		// Отправка формы
		fetch(quickOrderForm.action, {
			method: 'POST',
			body: formData,
		})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					quickOrderResponse.innerText = data.success
					quickOrderResponse.classList.add('alert', 'alert-success')
					quickOrderForm.reset()

					setTimeout(hideModal, 2000)
				} else {
					quickOrderResponse.innerText = data.errors
					quickOrderResponse.classList.add('alert', 'alert-danger')
				}
			})
			.catch(error => {
				console.error('Ошибка:', error)
				quickOrderResponse.innerText = 'Произошла ошибка при отправке формы.'
				quickOrderResponse.classList.add('alert', 'alert-danger')
			})
	})

	// Скрытие окна
	document.addEventListener('click', (event) => {
		const target = event.target

		if (target.closest('.js-quick-order-button')) {
			showModal()
			return
		}

		if (!target.closest('.js-quick-order-content') || target.closest('.js-quick-order-content-close')) {
			hideModal()
		}
	})
})
