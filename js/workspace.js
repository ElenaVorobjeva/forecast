function setListener() {
	document.querySelector(".header__close").addEventListener("click", () => document.querySelector('.header__open').style.display = 'block');
	document.querySelector(".header__open .burger-button-wrapper").addEventListener("click", () => {
		document.querySelector('nav').style.display = 'block';
		document.querySelector('body').style.overflow = 'hidden';
	});
	document.querySelector(".nav-header .close").addEventListener("click", () => {
		document.querySelector('nav').style.display = 'none';
		document.querySelector('body').style.overflow = 'scroll';
		document.querySelector('nav').classList.remove('submenu-open');
	});
	document.querySelector(".user-menu .burger-button-wrapper").addEventListener("click", () => document.querySelector('.header__open').style.display = 'none');
	document.querySelector(".user-menu .close").addEventListener("click", () => document.querySelector('.header__open').style.display = 'none');
	document.querySelector(".user-menu .user-menu-item").addEventListener("click", () => document.querySelector('nav').classList.toggle('submenu-open'));
	document.querySelector(".component_map-container img").addEventListener("click", () => {
		fullScreenFunction();
		document.querySelector('.full-screen').style.display = 'flex';
	});
	document.querySelector(".params__close").addEventListener("click", () => document.querySelector('.params__open').style.display = 'block');
	document.querySelector(".params_header .close").addEventListener("click", () => document.querySelector('.params__open').style.display = 'none');
}