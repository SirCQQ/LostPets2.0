function notificationFunction() {
    console.log("clicked");
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
    }
    else {
        if (formular.classList[0] === "show-form") {
            formular.classList.remove("show-form")
            formular.classList.add("hide-form")
        } else {
            if (formular.classList[0] === "hide-form") {
                formular.classList.remove("hide-form")
                formular.classList.add("show-form")
            }
        }
    }
}

function profileFunction() {
    let profile = document.getElementById("profile");
    if (profile.classList[0] === "hidden") {
        profile.classList.remove("hidden");
        console.log(profile.classList.length);
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
        if (profile.classList.length === 0){
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

