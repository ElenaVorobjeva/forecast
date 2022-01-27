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

$sections = ["ЦФО", "ПФО", "СЗФО", "СФО", "ЮФО и СКФО", "УФО", "ДФО", "Беларусь", "Наукастинг", "Мониторинг", "Администрирование"];

function getOneWorkspacePage($user) {
 
    

    return getOneWorkspacePattern(getSectionsList($user));
}

function getSectionsList($user) {
    $availableSections = getAvailableSectionsId($sections, $user[$availableDistrictsId], $user[$priorityDistrictId], $user[$role]));

    $sectionsList = "";
    for($i = 0; $i < count($availableSections); $i++) {
        $active = ($i == 0) ? "class='active' " : ""; //а какой раздел должен быть выбран???
        $sectionsList = $sectionsList."<li ".$active."><a href='#'>".$availableSections[$i]."</a></li>";
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
    return getAvailableSections($sections, $available);
}

function getAvailableSections($sections, $available) {
    for($i = 0; $i < count($available); $i++) {
        $available[$i] = $sections[$available[$i]];
    }
    return $available;
}
?>