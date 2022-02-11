<?php
/* 
Проверка пользователя:
1. Отправить запрос к БД
2. Найти запись с введенным логином
3. Взять id, логин и пароль пользователя
4. Вернуть объект пользователя
5. Сравнить данные с введенными

Если проверка успешная:
1. Отправить запрос к БД 
2. Найти пользователя по id
3. Вернуть все оставшиеся данные
4. Получить объект пользователя
5. Получить список доступных для пользователя разделов
6. Получить страницу по разделу (*)
7. Вернуть готовую страницу

Если проверка неуспешная:
1. Вывести сообщение с тестом ошибки
*/

include "one-workspace-pattern.php";

function getOneWorkspacePage($user) {
    $sections = ["0" => "ЦФО", "1" => "ПФО", "2" => "СЗФО", "3" => "СФО", "4" => "ЮФО и СКФО", "5" => "УФО",
                 "6" => "ДФО", "7" => "Беларусь", "8" => "Наукастинг", "9" => "Мониторинг", "10" => "Администрирование"];
    $types = ["0" => "Карты прогнозов", "1" => "Метеограммы", "2" => "Аэрологические диаграммы", 
              "3" => "Табличные данные", "4" => "Ансамблевый прогноз", "5" => "Вертикальные профили"];
    $domens = ["0" => "Земной шар", "1" => "Северная Евразия", "2" => "Европа", "3" => "ЕТР", 
               "4" => "ЦФО", "5" => "Московская область", "6" => "Новая Москва", "7" => "Москва"];
    $models = ["0" => "ICON-global", "1" => "COSMO-Ru6ENA", "2" => "COSMO-Ru13.2ENA", "3" => "COSMO-Ru7ETR", 
               "4" => "COSMO-RuBy 2km", "5" => "COSMO-Ru2.2CFO", "6" => "COSMO-Ru1.0M"];
    $elements = ["0" => "Давление на у.м.", "1" => "H500", "2" => "T2M", "3" => "Оcадки за 6 часов", 
                 "4" => "Оcадки за 24 часа", "5" => "Оcадки за 120 часов", "6" => "Общая облачность", "7" => "Облачность ср.яр.", 
                 "8" => "Осадки за 12 часов", "9" => "Порывы ветра", "10" => "Порывы ветра за 24 часа", "11" => "T850, давление", 
                 "12" => "Высота снега", "13" => "Прирост высоты свежевыпавшего снега за 24 часа", "14" => "CAPE", "15" => "CAPE (макс. за 24 часа)", 
                 "16" => "Радарная отражаемость", "17" => "Осадки, облачность", "18" => "Ветер", "19" => "T2M, T850", 
                 "20" => "Прирост высоты свежевыпавшего снега за 6 часов", "21" => "T850", "22" => "Точка росы", "23" => "Радиолокационная отражаемость", 
                 "24" => "STP", "25" => "Град", "26" => "Град за 24 часа", "27" => "Индекс молниевого потенциала", 
                 "28" => "Индекс молниевого потенциала за 24 часа", "29" => "STP", "30" => "Облачность н.яр.", 
                 "31" => "Экспериментальные расчеты линий тока, среднего ветра и его порывов на 10 м"];
    $terms = ["0" => "00", "1" => "06", "2" => "12", "3" => "18"]; 
//ПРОБЛЕМА:
//Ниже имеется ввиду порядковый идентификатор, а нужен идентификатор из БД
//РЕШЕНИЕ 1:
//Убрать получение массивов с идентификаторами из функций с получением списков и добавить в эту функцию. Тогда сразу можно будет взять в качестве активного первый элемент массива
    $activeSectionId = $user["priorityDistrictId"]; //$_GET["section"] //идентификатор активного раздела
    $activeSection = $sections[$activeSectionId]; //название активного раздела

    $availableSections = getAvailableSections($sections, $user["availableDistrictsId"], $user["priorityDistrictId"], $user["role"]); //доступные пользователю разделы
    $sectionsList =  getSectionsList($sections, $availableSections, $activeSectionId); //html-список из активных разделов 

    $miniMap = ($activeSectionId < 7) ? "<img src='img/mini-map-".$activeSectionId.".png' alt='Карта ".$activeSection."'>" : ""; //html-код для мини-карты

    $availableTypes = getAvailableTypes($activeSectionId); //[0, 1, 2, 3] //доступные пользователю типы информации
    $activeTypeId = $availableTypes[0]; //идентификатор активного типа информации
    $typesList = getTypesList($types, $availableTypes, $activeTypeId); //html-список из типов информации

    $availableDomens = getAvailableDomens($activeSectionId); //доступные пользователю домены
    $activeDomenId = $availableDomens[1]; //идентификатор активного домена 
    $domensList = getDomensList($domens, $availableDomens, $activeDomenId); //html-список из доменов

    $availableModels = getAvailableModels($activeDomenId); //доступные пользователю модели
    $activeModelId = $availableModels[1]; //идентификатор активной модели
    $modelsList = getModelsList($models, $availableModels, $activeModelId); //html-список из моделей

    $availableElements = getAvailableElements($activeDomenId, $activeModelId); //доступные пользователю элементы
    $activeElementId = $availableElements[2]; //идентификатор активных элементов
    $elementsList = getElementsList($elements, $availableElements, $activeElementId); //html-список из элементов

    $availableTerms = getAvailableTerms($activeDomenId, $activeModelId, $activeElementId); //доступные пользователю начальные сроки
    $activeTermId = $availableTerms[3]; //идентификатор активного начального срока
    $termsList = getTermsList($terms, $availableTerms, $activeTermId); //html-список из сроков

    $currentDate = date("Y-m-d"); //2021-09-13
    $times = getTimes($activeDomenId, $activeModelId, $activeElementId, $activeTermId, $terms[$activeTermId], $currentDate);

    $activeTime = getActiveTime();
    $linkPattern = getLinkPattern($activeDomenId, $activeModelId, $activeElementId, $activeTermId);
    $link = getLink($linkPattern, $currentDate, $activeTime);

    return getOneWorkspacePattern(
        $sectionsList, $activeSection, $miniMap, $typesList, 
        $domensList, $modelsList, $elementsList, $termsList,
        $currentDate, $times, $link
    );
}

function getSectionsList($sections, $availableSections, $activeSectionId) {
    $sectionsList = "";
    for($i = 0; $i < count($availableSections); $i++) {
        $active = ($availableSections[$i] == $activeSectionId) ? "class='active' " : "";
        $sectionsList = $sectionsList."<li ".$active."><button value='".$availableSections[$i]."'>".$sections[$availableSections[$i]]."</button></li>";
    }
    return $sectionsList;
}

function getTypesList($types, $availableTypes, $activeTypeId) {
    $typesList = "";
    for($i = 0; $i < count($availableTypes); $i++) {
        $active = ($availableTypes[$i] == $activeTypeId) ? "class='active' " : "";
        $typesList = $typesList."<li ".$active."><button value='".$availableTypes[$i]."'>".$types[$availableTypes[$i]]."</button></li>";
    }
    return $typesList;
}

function getDomensList($domens, $availableDomens, $activeDomenId) {
    $domensList = "";
    if($activeDomenId == null) $activeDomenId = $availableDomens[0];
    for($i = 0; $i < count($availableDomens); $i++) {
        $active = ($availableDomens[$i] == $activeDomenId) ? " checked" : "";
        $domensList = $domensList."<input type='radio' id='domen-input-".$i."' name='domen' value='".$availableDomens[$i]."'".$active.">";
        $domensList = $domensList."<label class='accordeon__item' for='domen-input-".$i."'>".$domens[$availableDomens[$i]]."</label>";
    }
    return $domensList;
}

function getModelsList($models, $availableModels, $activeModelId) {
    $modelsList = "";
    for($i = 0; $i < count($availableModels); $i++) {
        $active = ($availableModels[$i] == $activeModelId) ? " checked" : "";
        $modelsList = $modelsList."<input type='radio' id='model-input-".$i."' name='model' value='".$availableModels[$i]."'".$active.">";
        $modelsList = $modelsList."<label class='accordeon__item' for='model-input-".$i."'>".$models[$availableModels[$i]]."</label>";
    }
    return $modelsList;
}

function getElementsList($elements, $availableElements, $activeElementsId) {
    $elementsList = "";
    for($i = 0; $i < count($availableElements); $i++) {
        $active = ($availableElements[$i] == $activeElementId) ? " checked" : "";
        $elementsList = $elementsList."<input type='radio' id='elem-input-".$i."' name='elem' value='".$availableElements[$i]."'".$active.">";
        $elementsList = $elementsList."<label class='accordeon__item' for='elem-input-".$i."'>".$elements[$availableElements[$i]]."</label>";
    }
    return $elementsList;
}

function getTermsList($terms, $availableTerms, $activeTermId) {
    $termsList = "";
    for($i = 0; $i < count($availableTerms); $i++) {
        $active = ($availableTerms[$i] == $activeTermId) ? " checked" : "";
        $termsList = $termsList."<input type='radio' id='term-input-".$i."' name='term' value='".$availableTerms[$i]."'".$active.">";
        $termsList = $termsList."<label class='accordeon__item' for='term-input-".$i."'>".$terms[$availableTerms[$i]]."</label>";
    }
    return $termsList;
}

function getAvailableSections($sections, $available, $priority, $role) {
    // role:
    // - admin - доступно администрирование
    // - moderator - доступны мониторинг, статистика, добавление статей
    // - user - доступны только регионы и наукастинг

    array_splice($available, array_search($priority, $available), 1);
    array_unshift($available, $priority);
    if($role == "moderator" || $role == "admin") array_push($available, 9);
    if($role == "admin") array_push($available, 10);
    return $available;
}

function getAvailableTypes($id) {
    if($id == 0) { return [0, 1, 2, 3]; }
    else if($id == 1 || $id == 6) { return [0, 1]; }
    else if($id == 2 || $id == 3 || $id == 5) { return [0, 1, 2]; }
    else if($id == 4) { return [0, 1, 5]; }
    else if($id == 7) { return [0, 1, 2, 4]; }
    else if($id == 8) { return [0]; }
}

function getAvailableDomens($id) {
    return [0, 1, 2, 3, 4, 5, 6, 7];
}

function getAvailableModels($id) { //domen id
    if($id == 0) { return [0]; }
    else if($id == 1) { return [1, 2]; }
    else if($id == 2) { return [1]; }
    else if($id == 3) { return [3, 1, 4]; }
    else if($id == 4) { return [3, 1, 4, 5]; }
    else if($id == 5) { return [1, 4, 6]; }
    else if($id == 6) { return [1, 4, 6]; }
    else if($id == 7) { return [1, 4, 6]; }
}

function getAvailableElements($domenId, $modelId) { //model id
    if($domenId == 0 && $modelId == 0) { return [0, 1, 2, 3, 4, 5, 6, 7]; }
    else if($domenId == 1 && $modelId == 1) { return [1, 0, 8, 4, 5, 9, 10, 2, 11, 12, 13, 14, 15, 16]; }
    else if($domenId == 1 && $modelId == 2) { return [1, 0]; }
    else if($domenId == 2 && $modelId == 1) { return [17, 18, 8, 5, 2, 21, 14]; }
}

function getAvailableTerms($domenId, $modelId, $elemId) {
    return [0, 1, 2, 3];
}

function getTimes($activeDomenId, $activeModelId, $activeElementId, $activeTermId, $activeTerm, $currentDate) {
    $start = 0;
    $end = 78;
    $step = 6;
    $date = $currentDate."-".$activeTerm;
    return [$start, $end, $step, $date];
}

function getActiveTime() {
    return 0;
}

function getLinkPattern($activeDomenId, $activeModelId, $activeElementId, $activeTermId) {
    return "/res/224/images/cosmo6/yyyymmddhh/fm_SNG_H500_HHHhours.png";
}

function getLink($linkPattern, $currentDate, $activeTime) {
    return "/res/224/images/cosmo6/20220210/fm_SNG_H500_000hours.png";
}

?>