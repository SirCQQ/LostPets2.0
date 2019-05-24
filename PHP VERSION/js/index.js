function fromRegister(){
    let register = document.getElementById('register');
    console.log("i was clicked");
    if(register.classList[0]==='hidden')
    {
        register.classList.remove('hidden');
        register.classList.add('register-form');
    }
    else{
        if(register.classList[0]==='register-form'){
            register.classList.remove('register-form');
            register.classList.add('hiddenRegister');
        }
        else{
            if(register.classList[0]==='hiddenRegister'){
                register.classList.remove('hiddenRegister');
                register.classList.add('register-form');
            }
        }
    }
}