<?php 

include "get-success-response.php";

$users = array(
    "1" => array(
        "login" => "admin@yandex.ru",
        "password" => "adminadmin" 
    )
);

$id = $_POST["userId"];
$name = $_POST["nameInput"];  
$work = $_POST["workInput"];  
$profession = $_POST["professionInput"];
$district = $_POST["availableDistrict"];

if(array_key_exists($id, $users)) {
    //Пользователь существует
    $response = array(
        "isOk" => true,
        "content" => getSuccessResponse("Регистрация прошла успешно", true),
        "title" => "Регистрация"
    );
}
else {
    //Пользователь не существует
    $response = array(
        "isOk" => false,
        "error" => "К сожалению, произошла ошибка при регистрации. Попробуйте снова или опишите свою ситуацию <a href='https://docs.google.com/forms/d/e/1FAIpQLSf6DfYoNiEdB022UzWBNrNbaQ97IbzQaROFSCA7_ANJ3ThjVQ/viewform'>здесь</a>"
    );
}

echo json_encode($response);

?>