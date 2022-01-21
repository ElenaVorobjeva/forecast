<?php 

include "get-success-response.php";

$users = array(
    "1" => array(
        "login" => "admin@yandex.ru",
        "password" => "adminadmin" 
    )
);

$id = $_POST["userId"];
$password = $_POST["passwordInput"];

if(array_key_exists($id, $users)) {
    // Пользователь существует

    /* Сменить пароль на $password у пользователя с id = $id
        ля-ля-ля
    */

    $response = array(
        "isOk" => true,
        "content" => getSuccessResponse("Пароль успешно изменен", true),
        "title" => "Смена пароля"
    );
}
else {
    //Пользователь не существует
    $response = array(
        "isOk" => false,
        "error" => "К сожалению, произошла ошибка при смене пароль. <a href='reset-password.html'>Попробуйте снова</a> или опишите свою ситуацию <a href='https://docs.google.com/forms/d/e/1FAIpQLSf6DfYoNiEdB022UzWBNrNbaQ97IbzQaROFSCA7_ANJ3ThjVQ/viewform'>здесь</a>"
    );
}

echo json_encode($response);

?>