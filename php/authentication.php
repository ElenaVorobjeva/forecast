<?php 
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
include "get-one-workspace-page.php";

$user = array(
    "login" => "admin@yandex.ru",
    "password" => "adminadmin" 
);

$sections = array("ЦФО", "ПФО", "СЗФО", "СФО", "ЮФО и СКФО", "УФО", "ДФО", "Беларусь", "Наукастинг", "Мониторинг", "Администрирование");

$availableDistrictsId = array(0, 1, 2, 3, 4, 5, 6, 7);
$priorityDistrictId = 3;
$role = "admin";
$isNewUser = false;


$login = $_POST["emailInput"];
$password = $_POST["passwordInput"];

if($login == $user["login"]) {
    if($password == $user["password"]) {
        //Вход успешный
        $response = array(
            "isOk" => true,
            "content" => getOneWorkspacePage(getAvailableDistrictId($sections, $availableDistrictsId, $priorityDistrictId, $role), $isNewUser),
            "title" => "Одна рабочая область"
        );
    }
    else {
        //Неверный пароль
        $response = array(
            "isOk" => false,
            "error" => "Пользователя с таким логином и паролем не существует. Попробуйте снова или <a href='reset-password.html'>восстановите пароль</a>"
        );
    }
}
else {
    //Пользователь не найден
    $response = array(
        "isOk" => false,
        "error" => "Пользователя с таким логином и паролем не существует. Попробуйте снова или <a href='reset-password.html'>восстановите пароль</a>"
    );
}

echo json_encode($response);

function getAvailableDistrictId($sections, $available, $priority, $role) {
    // role
    // admin - доступно администрирование
    // moderator - доступны мониторинг, статистика, добавление статей
    // user - доступны только регионы и наукастинг

    array_splice($available, array_search($priority, $available), 1);
    array_unshift($available, $priority);
    if($role == "moderator" || $role == "admin") array_push($available, 9);
    if($role == "admin") array_push($available, 10);
    return getAvailableDistrict($sections, $available);
}

function getAvailableDistrict($sections, $available) {
    for($i = 0; $i < count($available); $i++) {
        $available[$i] = $sections[$available[$i]];
    }
    return $available;
}

?>