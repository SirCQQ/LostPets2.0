function register() {
    var register = document.getElementById("register");
    if (register.classList[0] === "hidden") {
        register.classList.remove("hidden");
        register.classList.add("notHiddenRegister");
    }else{
    if (register.classList[0] === "hiddenRegister") {
        register.classList.remove("hiddenRegister");
        register.classList.add("notHiddenRegister");
    }
    else {
        register.classList.remove("notHiddenRegister");
        register.classList.add("hiddenRegister");
    }
}
}

function login() {
    var login = document.getElementById("login");
    if (login.classList[0] === "hidden") {
        login.classList.remove("hidden");
        login.classList.add("notHiddenLogin");
    }
    else{

    if (login.classList[0] === "hiddenLogin") {
        login.classList.remove("hiddenLogin");
        login.classList.add("notHiddenLogin");
    }
    else {
        login.classList.remove("notHiddenLogin");
        login.classList.add("hiddenLogin");
    }
}
}
