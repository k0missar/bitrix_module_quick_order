document.addEventListener('DOMContentLoaded', ()=> {
	const quickOrderButton = document.querySelector('.js-quick-order-button')
	const quickOrderContent = document.querySelector('.js-quick-order-content')

	if(quickOrderButton && quickOrderContent) {
		quickOrderButton.addEventListener('click', ()=> {
			quickOrderContent.classList.toggle('quick-order-content--hide')
		})
	}
})