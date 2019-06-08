function notificationFunction() {
    let notification = document.getElementById("notifications");
    if (notification.classList[0] === "hidden") {
        notification.classList.remove("hidden");
        notification.classList.add("show-not");
    } else {
        if (notification.classList[0] === "hide-not") {
            notification.classList.remove("hide-not");
            notification.classList.add("show-not");

        }
        else {
            notification.classList.remove("show-not");
            notification.classList.add("hide-not");
        }

    }
}

function formularFunction() {
    let formular = document.getElementById('input');
  
    if (formular.classList[0] === "hidden") {
        formular.classList.remove("hidden")
        formular.classList.add("show-form")
        clearMap(mymap);

    }
    else {
        if (formular.classList[0] === "show-form") {
            formular.classList.remove("show-form")
            formular.classList.add("hide-form")
            clearMap(mymap);

        } else {
            if (formular.classList[0] === "hide-form") {
                formular.classList.remove("hide-form")
                formular.classList.add("show-form")
                clearMap(mymap);
            }
        }
    }
}

function profileFunction() {
    let profile = document.getElementById("profile");
    if (profile.classList[0] === "hidden") {
        profile.classList.remove("hidden");
        profile.classList.add("show-profile");
    } else {
        if (profile.classList[0] === "hide-profile") {
            profile.classList.remove("hide-profile");
            profile.classList.add("show-profile");
        }
        else {
            profile.classList.remove("show-profile");
            profile.classList.add("hide-profile");
        }
    }
}

function profile() {
    let notification = document.getElementById("notifications");
    let formular = document.getElementById('input');
    if (notification.classList[0] === "show-not" || formular.classList[0] === "show-form") {
        formular.classList.remove("show-form")
        if (formular.classList.length === 0) {
            formular.classList.add("hide-form")
        }
        notification.classList.remove("show-not");
        if (notification.classList.length === 0) {
            notification.classList.add("hide-not");
        }
        setTimeout(profileFunction, 500);
    }
    else {
        profileFunction();
    }
}

function notification() {
    let profile = document.getElementById("profile");
    let formular = document.getElementById('input');
    if (profile.classList[0] === 'show-profile' || formular.classList[0] === "show-form") {
        formular.classList.remove("show-form")
        if (formular.classList.length === 0) {
            formular.classList.add("hide-form")
        }
        profile.classList.remove("show-profile");
        if (profile.classList.length === 0) {
            profile.classList.add("hide-profile");
        }
        setTimeout(notificationFunction, 500);
    }
    else {
        notificationFunction();
    }
}

function formular() {
    let profile = document.getElementById("profile");
    let notification = document.getElementById("notifications");
    if (profile.classList[0] === 'show-profile' || notification.classList[0] === "show-not") {
        profile.classList.remove("show-profile");
        if (profile.classList.length === 0) {
            profile.classList.add("hide-profile");
        }
        notification.classList.remove("show-not");
        if (notification.classList.length === 0) {
            notification.classList.add("hide-not");
        }
        setTimeout(formularFunction, 500);
    }
    else {
        formularFunction();
    }
}

function register() {
    var register = document.getElementById("register");
    if (register.classList[0] === "hidden") {
        register.classList.remove("hidden");
        register.classList.add("notHiddenRegister");
    } else {
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

function fromRegister() {
    let register = document.getElementById('register');
    if (register.classList[0] === 'hidden') {
        register.classList.remove('hidden');
        register.classList.add('register-form');
    }
    else {
        if (register.classList[0] === 'register-form') {
            register.classList.remove('register-form');
            register.classList.add('hiddenRegister');
        }
        else {
            if (register.classList[0] === 'hiddenRegister') {
                register.classList.remove('hiddenRegister');
                register.classList.add('register-form');
            }
        }
    }
}

function fromRegister() {
    let register = document.getElementById('register');
    if (register.classList[0] === 'hidden') {
        register.classList.remove('hidden');
        register.classList.add('register-form');
    }
    else {
        if (register.classList[0] === 'register-form') {
            register.classList.remove('register-form');
            register.classList.add('hiddenRegister');
        }
        else {
            if (register.classList[0] === 'hiddenRegister') {
                register.classList.remove('hiddenRegister');
                register.classList.add('register-form');
            }
        }
    }
}

function foundPet(pet_id) {
    let found = document.getElementById('found-pet');

    if (found.classList[0] === 'hidden') {
        found.classList.remove('hidden')
        found.classList.add('found-show')
        document.getElementById('id_pet_found').value = pet_id;
        clearMap(mymap);
    }


    else {
        if (found.classList[0] === 'found-show') {
            found.classList.remove('found-show')
            found.classList.add('found-hidden')
            document.getElementById('id_pet_found').value = ''
            clearMap(mymap);
        }
        else {
            found.classList.remove('found-hidden')
            found.classList.add('found-show')
            document.getElementById('id_pet_found').value = pet_id;
            clearMap(mymap);

        }
    }
}
function changePet(pet_id) {
    let change = document.getElementById('change-pet');
    if (change.classList[0] === 'changeLocation-show') {
        change.classList.remove('changeLocation-show')
        change.classList.add('changeLocation-hidden')
        document.getElementById('id_pet_change').value = ''
        clearMap(mymap);
    }
    else {
        if (change.classList[0] === 'hidden') {
            change.classList.remove('hidden')
            change.classList.add('changeLocation-show')
            document.getElementById('id_pet_change').value = pet_id;
            clearMap(mymap);
        }
        else {

            change.classList.remove('changeLocation-hidden')
            change.classList.add('changeLocation-show')
            document.getElementById('id_pet_change').value = pet_id;
            clearMap(mymap);
        }

    }
}

