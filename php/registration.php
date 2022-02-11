<?php

$users = array(
    "0" => array(
        "login" => "admin@yandex.ru",
        "password" => "adminadmin" 
    )
);

$login = $_POST["emailInput"];
$password = $_POST["passwordInput"];

if($login !== $users[0]["login"]) {
    //Создание пользователя
    $isExist = true;
    $id = 1;
    if($isExist) {
        //Пользователь создан
        $response = array(
            "isOk" => true,
            "content" => getRegistrationForm($id),
            "title" => "Регистрация (2/2)"
        );
    }
    else {
        //Ошибка в созднии пользователя
        $response = array(
            "isOk" => false,
            "error" => "К сожалению, произошла ошибка при регистрации. Попробуйте снова или опишите свою ситуацию <a href='https://docs.google.com/forms/d/e/1FAIpQLSf6DfYoNiEdB022UzWBNrNbaQ97IbzQaROFSCA7_ANJ3ThjVQ/viewform'>здесь</a>"
        );
    }
}
else {
    //Пользователь уже существует
    $response = array(
        "isOk" => false,
        "error" => "Пользователь с таким email уже существует. Попробуйте <a href='authentication.html'>войти на сайт</a> или <a href='reset-password.html'>восстановить пароль</a>"
    );
}

echo json_encode($response); 

function getRegistrationForm($id) {
    return "
        <div class='authentication'>
            <header class='auth_header'>
                <div class='logo clearfix'>
                    <img src='img/logo-hmc.png' alt='Logotype'>
                    <span>Гидрометцентр России</span>
                </div>
                <div class='title'>
                    Сайт продукции COSMO-Ru
                </div>
            </header>
            <main>
                <form name='userInfoForm'>
                    <h1>Регистрация в системе</h1>
                    <p>2 / 2</p>
                    <div class='name input-container'>
                        <input type='text' name='nameInput' placeholder='ФИО'>
                    </div>
                    <div class='work input-container'>
                        <input type='text' name='workInput' placeholder='Место работы'>
                    </div>
                    <div class='profession input-container'>
                        <input type='text' name='professionInput' placeholder='Должность'>
                    </div>
                    <select name='availableDistrict'>
                        <option value='0'>Наиболее значимый для Вас регион</option>
                        <option value='1'>ЦФО</option>
                        <option value='2'>ПФО</option>
                        <option value='3'>СЗФО</option>
                        <option value='4'>СФО</option>
                        <option value='5'>ЮФО и СКФО</option>
                        <option value='6'>УФО</option>
                        <option value='7'>ДФО</option>
                        <option value='8'>Беларусь</option>
                    </select>
                    <input type='hidden' name='userId' value='".$id."'>
                    <div class='response negative'></div>
                    <button type='submit'>Сохранить</button>
                </form>
            </main>
        </div>
        <script src='js/show-hide-password.js'></script>
        <script src='js/validate-form.js'></script>
    ";
}

?>