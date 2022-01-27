<?php 
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

/* 
Проверка пользователя:
1. Отправить запрос к БД
2. Найти запись с введенным логином
3. Взять id, логин и пароль пользователя
4. Вернуть объект пользователя
5. Сравнить данные с введенными (*)

Если проверка успешная:
1. Отправить запрос к БД 
2. Найти пользователя по id
3. Вернуть все оставшиеся данные
4. Получить объект пользователя
5. Получить список доступных для пользователя разделов
6. Получить страницу по разделу
7. Вернуть готовую страницу (*)

Если проверка неуспешная:
1. Вывести сообщение с тестом ошибки(*)
*/

include "get-user-data.php";
include "get-one-workspace-page.php";

$login = $_POST["emailInput"];
$password = $_POST["passwordInput"];
$user = getUserData($login);

if($login != null) {
    if($password == $user["password"]) {
        //Вход успешный
        $response = array(
            "isOk" => true,
            "content" => getOneWorkspacePage($user),
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
?>