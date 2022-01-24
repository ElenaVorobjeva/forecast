document.forms[0].onsubmit = (event) => validateForm(event, document.forms[0]);

function validateForm(e, form) {
    e.preventDefault();
    document.querySelector(".response").style.display = "none";

    let isValid = true;
    let inputContainers = document.querySelectorAll(".input-container");

    for (let container of inputContainers) {
        let [isValidInput, error] = getCheckMethod(container)(container.querySelector("input"));

        if (!isValidInput) {
            createErrorHint(
                container,
                container.querySelector("input"),
                container.querySelector(".hint"),
                error
            );
            isValid = false;
        }
        else {
            removeErrorHint(
                container.querySelector("input"),
                container.querySelector(".hint")
            );
        }
    }

    if (isValid) makeQuery(form);
}

function createErrorHint(container, input, hint, error) {
    if (hint) hint.remove();
    input.classList.add('error');
    let elem = document.createElement('div');
    elem.className = "hint";
    elem.setAttribute('data-hint', error);
    elem.innerHTML = "!";
    container.append(elem);
    return;
}

function removeErrorHint(input, hint) {
    input.classList.remove('error');
    input.classList.add('correct');
    if (hint) hint.remove();
}

function getCheckMethod(container) {
    let className = container.classList[0];
    if (className == "email") return checkEmail
    else if (className == "password") return checkPassword
    else if (className == "name" || className == "work" || className == "profession") return checkNotEmpty;
}

function checkEmail(input) {
    let reg = /^[\w]{1}[\w-\.]*@[\w-]+\.[a-z]{2,4}$/i;

    if (input.value === "") {
        return [false, 'Обязательное поле'];
    }
    else if (!reg.test(input.value)) {
        return [false, 'Введите адрес электронной почты'];
    }
    return [true, ""];
}

function checkPassword(input) {
    if (input.value == "") {
        return [false, 'Обязательное поле'];
    }
    else if (input.value.length < 8) {
        return [false, 'Пароль не может быть короче 8 символов'];
    }
    return [true, ""];
}

function checkNotEmpty(input) {
    if (input.value == "") {
        return [false, 'Обязательное поле'];
    }
    return [true, ""];
}

function makeQuery(form) {
    fetch(getUrl(form), {
        method: "POST",
        body: new FormData(form)
    }).then(
        successResponse => {
            if (successResponse.ok) successResponse.json().then(
                result => {
                    if (result.isOk) {
                        document.querySelector("html").innerHTML = result.content;
                        document.title = result.title;
                        if (document.forms[0]) document.forms[0].onsubmit = (event) => validateForm(event, document.forms[0]);
                        setListener();
                    }
                    else {
                        showErrorMessage(
                            form,
                            document.querySelector(".response"),
                            result.error
                        );
                    }
                }
            );
            else {
                showErrorMessage(
                    form,
                    document.querySelector(".response"),
                    "К сожалению, прозошла ошибка. Попробуйте позднее."
                );
            }
        },
        () => {
            showErrorMessage(
                form,
                document.querySelector(".response"),
                "К сожалению, прозошла ошибка. Попробуйте позднее."
            );
        }
    );
}

function getUrl(form) {
    if (form.name == "authForm") return "php/authentication.php"
    else if (form.name == "regForm") return "php/registration.php"
    else if (form.name == "userInfoForm") return "php/registration-2.php"
    else if (form.name == "resetForm") return "php/reset-password.php"
    else if (form.name == "setForm") return "php/set-password.php";
}

function showErrorMessage(form, errorBlock, error) {
    errorBlock.innerHTML = error;
    form.reset();
    form.querySelectorAll("input").forEach(element => element.classList.remove("correct"));
    errorBlock.style.display = "block";
}