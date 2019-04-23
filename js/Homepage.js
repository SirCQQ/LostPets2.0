function notificationFunction() {
    var notification = document.getElementById("notifications");
    if (notification.classList[0] === "hidden") {
        notification.classList.remove("hidden");
        notification.classList.add("NotificationsShow");
    }else{
    if (notification.classList[0] === "NotificationNotShow") {
        notification.classList.remove("NotificationNotShow");
        notification.classList.add("NotificationsShow");
    }
    else {
        notification.classList.remove("NotificationsShow");
        notification.classList.add("NotificationNotShow");
    }

}
}



let name="Max"
function profileFunction() {
    var profile = document.getElementById("profile");
   
    
    
    if (profile.classList[0] === "hidden") {
        profile.classList.remove("hidden");
        profile.classList.add("ProfileShow");
    }else{
    if (profile.classList[0] === "NotProfileShow") {
        profile.classList.remove("NotProfileShow");
        profile.classList.add("ProfileShow");
    }
    else {
        profile.classList.remove("ProfileShow");
        profile.classList.add("NotProfileShow");
    }
}  
}

function profile(){
    var notification = document.getElementById("notifications");
    if(notification.classList[0]==="NotificationsShow")
    {
        notification.classList.remove("NotificationsShow");
        notification.classList.add("NotificationNotShow");
        console.log("wait a sec");
        setTimeout(profileFunction,1000);     
    }
    else {
        profileFunction();
    }
}
function notification(){
    var profile = document.getElementById("profile");
    console.log(profile);
    console.log(profile.children[0].firstChild)

    // console.log(profile.children[0].textContent)
    if(profile.classList[0]==='ProfileShow')
    {
        profile.classList.remove("ProfileShow");
        profile.classList.add("NotProfileShow");
        setTimeout(notificationFunction,1005);
    }
    else{
        notificationFunction();
    }
}

function change (){
    var card= document.getElementById('info');
    card.cardList.remove('infoNotShow')
    card.cardList.add('infoShow')
}