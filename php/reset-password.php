<?php 

include "get-success-response.php";

$users = array(
    "0" => array(
        "login" => "admin@yandex.ru",
        "password" => "adminadmin" 
    )
);

$login = $_POST["emailInput"];

if($login === $users[0]["login"]) {
    // Пользователь существует

    /* Отправка письма с ссылкой на электронную почту $login
        ля-ля-ля
    */

    $response = array(
        "isOk" => true,
        "content" => getSuccessResponse("На Вашу электронную почту отправленно письмо с подтверждением. Перейдите по ссылке в нем, чтобы сменить пароль.", false),
        "title" => "Смена пароля"
    );
}
else {
    //Пользователь не существует
    $response = array(
        "isOk" => false,
        "error" => "Пользователь с таким email не существует. Попробуйте еще раз или <a href='registration.html'>зарегистрируйтесь на сайте</a>"
    );
}

echo json_encode($response);

?>