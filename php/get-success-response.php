<?php

function getSuccessResponse($message, $link) {
    $linkText = ($link) ? "<a class='center' href='authentication.html'>Войти в систему</a>" : "";
    return "
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title></title>
            <link rel='stylesheet' href='css/common.css'>
            <link rel='stylesheet' href='css/authentication.css'>
        </head>
        <body>
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
                    <div class='positive'>
                        <p>".$message."</p>".
                        $linkText
                    ."</div>
                </main>
            </div>
        </body>
    ";
}

?>