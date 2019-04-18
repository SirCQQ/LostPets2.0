function register()
{
var login=document.getElementById("register");
if(login.classList[0]==="hiddenregister"){
login.classList.remove("hiddenregister");
login.classList.add("notHiddenRegister");}
else{login.classList.remove("notHiddenRegister");
login.classList.add("hiddenregister");}
}