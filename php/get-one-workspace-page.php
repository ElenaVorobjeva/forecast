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
$sections = ["0" => "ЦФО", "1" => "ПФО", "2" => "СЗФО", "3" => "СФО", "4" => "ЮФО и СКФО", "5" => "УФО",
             "6" => "ДФО", "7" => "Беларусь", "8" => "Наукастинг", "9" => "Мониторинг", "10" => "Администрирование"];

function getOneWorkspacePage($user) {
    $sections = ["0" => "ЦФО", "1" => "ПФО", "2" => "СЗФО", "3" => "СФО", "4" => "ЮФО и СКФО", "5" => "УФО",
             "6" => "ДФО", "7" => "Беларусь", "8" => "Наукастинг", "9" => "Мониторинг", "10" => "Администрирование"];

    $activeSectionId = $user["priorityDistrictId"]; //$_GET["section"]
    $activeSection = $sections[$activeSectionId];
    $sectionsList =  getSectionsList($sections, $user, $activeSectionId);
    $miniMapScr = "img/mini-map-".$activeSectionId.".png";
    $activeTypeId = 0;
    // $typeList = getTypeList();
    return getOneWorkspacePattern($sectionsList, $activeSection, $miniMapScr);
}

function getSectionsList($sections, $user, $activeSectionId) {
    $availableSections = getAvailableSectionsId($sections, $user["availableDistrictsId"], $user["priorityDistrictId"], $user["role"]);
    $sectionsList = "";
    for($i = 0; $i < count($availableSections); $i++) {
        $active = ($availableSections[$i] == $activeSectionId) ? "class='active' " : "";
        $sectionsList = $sectionsList."<li ".$active."><button value='".$availableSections[$i]."'>".$sections[$availableSections[$i]]."</button></li>";
    }
    return $sectionsList;
}

function getAvailableSectionsId($sections, $available, $priority, $role) {
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
?>