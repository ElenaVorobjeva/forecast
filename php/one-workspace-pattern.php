<?php
function getOneWorkspacePattern(
	$sectionsList, $activeSection, $miniMap, $typesList, 
	$domensList, $modelsList, $elementslist, $termsList,
	$currentDate, $times, $link
){
	return "
		<head>
			<meta charset='UTF-8'>
			<meta http-equiv='X-UA-Compatible' content='IE=edge'>
			<meta name='viewport' content='width=device-width, initial-scale=1.0'>
			<title>".$activeSection."</title>
			<link rel='stylesheet' href='css/common.css'>
			<link rel='stylesheet' href='css/one-workspace.css'>
		</head>
		<body>
			<div class='wrapper'>
				<div class='header__close'>
					<div class='burger-button-wrapper'>
						<div class='burger-button'></div>
					</div>
				</div>
				<header class='clearfix header__open'>
					<div class='logo clearfix'>
						<img src='img/logo-hmc.png' alt='logo'>
						<span>Гидрометцентр России</span>
					</div>
					<div class='burger-button-wrapper'>
						<div class='burger-button'></div>
					</div>
					<nav>
						<div>
							<div class='nav-header'>
								<div class='close'></div>
							</div>
							<div class='nav-top'>
								<ul class='menu'>".
									$typesList.
								"</ul>
								<a class='add-hide-workspace' href='two-workspace.html'>Добавить рабочую область</a>
							</div>
						</div>
						<div>
							<div class='mini-map'>".
								$miniMap.
							"</div>
							<div class='nav-bottom'>
								<ul class='menu'>  
									<li class='user-menu'>
										<div class='burger-button-wrapper'>
											<div class='burger-button'></div>
										</div>
										<div class='close'></div>
										<div class='user-menu-item'>
											<h1 class='not-header'>".$activeSection."</h1>
											<ul class='submenu'>".
												$sectionsList.
												"<li><a href='extra-info/instruction.html'>Доп. информация</a></li>
												<li><a href='https://docs.google.com/forms/d/e/1FAIpQLSf6DfYoNiEdB022UzWBNrNbaQ97IbzQaROFSCA7_ANJ3ThjVQ/viewform' target='_blank'>Оставить отзыв</a></li>
												<li><a href='authentication.html'>Выйти</a></li>
											</ul>
										</div>  
									</li>
								</ul>
							</div>
						</div>
					</nav>
				</header>
				<main>
					<div>
						<div class='previous-wrapper'>
							<div id='previous-button' class='prev-button round-button'>
								<div class='arrow left'></div>
							</div>
							<div class='prev'></div>
						</div>
						<div class='component_map-container'>
							<img src='".$link."' alt='Карта'>
						</div>
						<div class='next-wrapper'>
							<div class='empty-block'></div>
							<div>
								<div id='next-button' class='next-button round-button'>
									<div class='arrow right'></div>
								</div>
								<div class='next'></div>
							</div>
							<div id='play-pause-button' class='play-pause-button round-button'>
								<div class='triangle'></div>
							</div>
						</div>
					</div>
					<div 
						class='slider-wrapper' 
						data-start='".$times[0]."' data-end='".$times[1]."' 
						data-step='".$times[2]."' data-date='".$times[3]."'
					>
						<div>
							<div class='start'></div>
							<div class='prev'></div>
						</div>
						<div>
							<div class='slider-label'></div>
							<input id='sliderInput' type='range' name='slider'>
							<div class='day-container'></div>
						</div>
						<div>
							<div class='end'></div>
							<div class='next'></div>
						</div>
					</div>
				</main>
				<div class='params__close'>
					<div>Параметры</div>
				</div>
				<div class='params-wrapper params__open'>
					<div class='params'>
						<div class='params_header'>
							<h2>Параметры</h2>
							<div class='close'></div>
						</div>
						<div class='params-group accordeon__wrapper'>
							<input type='checkbox' id='domen-group' name='header' checked>
							<label for='domen-group' class='title accordeon__header'>Домен</label>
							<div class='params-group-list domen-list accordeon__body'>".
								$domensList.
							"</div>
						</div>
						<div class='params-group accordeon__wrapper'>
							<input type='checkbox' id='model-group' name='header' checked>
							<label for='model-group' class='title accordeon__header'>Модель</label>
							<div class='params-group-list model-list accordeon__body'>".
								$modelsList.	
							"</div>
						</div>
						<div class='params-group accordeon__wrapper'>
							<input type='checkbox' id='elem-group' name='header' checked>
							<label for='elem-group' class='title accordeon__header'>Метеоэлементы</label>
							<div class='params-group-list elem-list accordeon__body'>".
								$elementslist.	
							"</div>
						</div>
						<div class='params-group accordeon__wrapper'>
							<input type='checkbox' id='term-group' name='header' checked>
							<label for='term-group' class='title accordeon__header clearfix'>Начальный срок (UTC)</label>
							<div class='params-group-list term-list accordeon__body'>".
								$termsList.
							"</div>
						</div>
						<div class='params-group accordeon__wrapper'>
							<input type='checkbox' id='date-group' name='header' checked>
							<label for='date-group' class='title accordeon__header'>Дата прогноза</label>
							<div class='params-group-list date-list accordeon__body'>
								<input type='date' value='".$currentDate."'>
							</div>
						</div>
						<div class='params-group accordeon__wrapper'>
							<input type='checkbox' id='speed-group' name='header'>
							<label for='speed-group' class='title accordeon__header'>Скорость воспроизведения</label>
							<div class='params-group-list speed-list accordeon__body'>
								<input type='radio' id='speed-input-0' name='speed'>
								<label class='accordeon__item' for='speed-input-0'>0.75x</label>
								<input type='radio' id='speed-input-1' name='speed' checked>
								<label class='accordeon__item' for='speed-input-1'>1x</label>
								<input type='radio' id='speed-input-2' name='speed'>
								<label class='accordeon__item' for='speed-input-2'>1.25x</label>
								<input type='radio' id='speed-input-3' name='speed'>
								<label class='accordeon__item' for='speed-input-3'>1.5x</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class='full-screen'>
				<div class='full-screen__container'>
					<img src='".$link."' alt='Карта'>
				</div>
				<div class='full-screen__nav'>
					<div id='zoom-down-button'><div class='minus'></div></div>
					<div id='zoom-up-button'><div class='plus'></div></div>
					<div id='full-screen-button'><div class='open-full-screen'></div></div>
					<div id='previous-button'><div class='arrow left'></div></div>
					<div id='play-pause-button'><div class='triangle'></div></div>
					<div id='next-button'><div class='arrow right'></div></div>
					<div id='close-button'><div class='close'></div></div>
				</div>
			</div>
			<script src='js/slider.js'></script>
			<script src='js/full-screen.js'></script>
			<script src='js/workspace.js'></script> 
		</body>
	";
}
?>