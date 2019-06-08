// DECLARATII
let pets;
let notificari;
let animalePierdute;
let id = document.getElementById("userId").textContent;
let url = "http://localhost:80/api/userPhoto/" + id;
let petsInPage=[]
//pentru harta
var mymap;
let latlng = [];
var marker = {}
// let card = document.querySelectorAll("div.pet-card");
let setCurrentLocationOnMap=true;


mymap = L.map('mapid').setView([47.16156163590006, 27.584009170532227], 13);
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    maxZoom: 20,
    id: 'mapbox.streets',
    accessToken: 'pk.eyJ1Ijoic2lyY3FxIiwiYSI6ImNqdmF1bWIyaTFnYWIzeXMxMDBnN21oaDMifQ.fzVeJxr-LkQUfAKR5Tmjhw'
}).addTo(mymap);


mymap.on('click',onMapClickPutMarker);



function getProfilePic() {
    fetch(url)
        .then(resp => resp.text())
        .then(respText => {
            // console.log(respText);
            profileImg = document.getElementById("profile_pic");
            if (respText.trim() !== '.') {
                // console.log(respText);
                profileImg.setAttribute('src', "./ProfilePic/" + respText);
            }
            else {
                if (respText.trim() === '.') {
                    profileImg.setAttribute('src', "./ProfilePic/BasicProfileImg.png");
                }
            }
        }).catch(err => {
            console.log("Error at : ", err)
        })

}

function getActualCoords(){
    navigator.geolocation.getCurrentPosition(function(position) {
        latlng.lat=position.coords.latitude;
        latlng.lng=position.coords.longitude;
        if(setCurrentLocationOnMap){
        mymap.setView([latlng.lat,latlng.lng], 18);
            setCurrentLocationOnMap=false;
        }
      });
    }

function getAllPets() {
    fetch("http://localhost:80/api/getAllPets")
        .then(resp => resp.json())
        .then(resp => {
            pets = resp;
            console.log(resp)
           setTimeout(createPetsCards(),3000);

        })
        .catch(err => {
            console.log("Error at :", err)
        });
}

function getLostAnimals() {
    fetch("http://localhost:80/api/lostAnimals")
        .then(resp => resp.json())
        .then(respJson => {
            // console.log("Lost animals", respJson);
            animalePierdute = respJson;
        }).catch(err => {
            console.log("Error at : ", err)
        })


}

function getNotifications() {
    fetch("http://localhost:80/api/notifications")
        .then(resp => resp.json())
        .then(respJson => {
            // console.log("Pentru notificari: ", respJson)
            notificari = respJson;
            // console.log(notificari)
            // console.log(latlng);

            // createNotification();
        })
        .catch(err => {
            console.log("Error at : ", err)
        })
    // setTimeout(function(){createNotification()},2000);
}

function onMapClickPutMarker(e) {
    let form = document.getElementById('input')
    let change = document.getElementById('change-pet')
    let formfound = document.getElementById('found-pet')
    clearMap(mymap);
    if (form.classList[0] === 'show-form' || change.classList[0] === 'changeLocation-show' || formfound.classList[0] === 'found-show') {
        addMarker(e.latlng.lat, e.latlng.lng, mymap);
    }
}
function putMarkerAtPetPosition(idPet) {
    let id = idPet;
    let lat, lng;
    let tab = animalePierdute;
    for (let i = 0; i < tab.length; i++) {
        if (tab[i].pet_id === idPet) {
            lat = tab[i].lat_lost;
            lng = tab[i].lng_lost;
        }
    }
    latP = lat.split(',');
    lngP = lng.split(',');
    if(latP[1]!==undefined){
    lat = latP[0] + '.' + latP[1];
    lng = lngP[0] + '.' + lngP[1];
    }
    clearMap(mymap);
    addMarker(lat, lng, mymap);
    mymap.setView(L.latLng(lat, lng), 18)
}

function login(e) {
    // e.preventDefault();
    let emailD = document.getElementById('mail').value;
    let passwordD = document.getElementById('pwd').value;
    let loginBody = {
        email: emailD,
        password: passwordD
    }
    fetch("/api/login", {
        method: "POST",
        body: JSON.stringify(loginBody),
        headers: {
            "Content-Type": "application/json"
        }
    })
    .then(resp => resp.json())
        .then(resp => {
            location.reload()
        })
        .catch(err => { console.log(err) })


}



function calculateIfThePointIsInTheCircle(pet_id)
{
    let XPoint,YPoint;
    let R=Math.pow(0.0180875982382679,2);
    R=parseFloat(R.toFixed(5));
    animalePierdute.forEach(animal=>{
        if(pet_id===animal.pet_id)
        {
            XPoint=animal.lat_lost;
            YPoint=animal.lng_lost;
        }        
    })
    let array=XPoint.split(',');    
    if(array.length===2){
    XPoint=array[0]+'.'+array[1];}
    let array2=YPoint.split(',');    
    if(array2.length===2){
    YPoint=array2[0]+'.'+array2[1];}
    let VX=Math.pow(XPoint-latlng.lat,2)
    let VY=Math.pow(YPoint-latlng.lng,2)
    if(VX<0){VX*=-1;}
    if(VY<0){VY*=-1;}
    let Point=VX+VY;
       if(Point<=R)
    {
        return true;
    }
    else{
        return false;
    }

}

function createNotification()
{   
    let notBar=document.getElementById('notifications')
    while (notBar.firstChild) {
        notBar.removeChild(notBar.firstChild);
    }
    let i=0;
    notificari.forEach(not=>
        {
            if(
                calculateIfThePointIsInTheCircle(not.pet_id)
                )
            {let noti=document.createElement('li');
            noti.textContent=not.pet_name+" a fost peirdut in zona "+not.zona;
            notBar.appendChild(noti);
        }
        })

}

function createPetCard(pet) {
    
    let cards = document.querySelector('div.cards');
    let card = document.createElement('div');
    card.classList.add('pet-card');
    card.setAttribute('id',"pet-"+pet.pet.pet_id)
    let infoPet = document.createElement('div');
    let petName = document.createElement('p');
    let petDetails = document.createElement('p');
    let petZone = document.createElement('p');
    let petReward = document.createElement('p');
    let id = pet.pet.pet_id;
    let type = document.createElement('p');
    let nrTelefonUser = document.createElement('p');
    let emailUser = document.createElement('p');
    
    
    let img = document.createElement('img')
    img.src = "./PetPic/" + pet.pet.pet_photo;

    petName.classList.add('name');
    petName.setAttribute('pet-id', id);
    petName.textContent = pet.pet.pet_name;

    petDetails.classList.add('pet-details');
    petDetails.setAttribute('pet-id', id);
    petDetails.textContent = "Detalii: " + pet.pet.pet_details

    petReward.classList.add('pet-reward');
    petReward.setAttribute('pet-id', id);
    petReward.textContent = "Recompensa: " + pet.pet.reward;
// console.log(pet.pet.reward)
    petZone.classList.add('pet-zone');
    petZone.setAttribute('pet-id', id);
    petZone.textContent = "Zona in care a fost pierdut: " + pet.pet.zona_pierdut;

    type.classList.add('pet-type');
    type.setAttribute('pet-id', id);
    type.textContent = pet.pet.pet_type;

    nrTelefonUser.setAttribute('pet-id', id);
    emailUser.setAttribute('pet-id', id);

    card.appendChild(petName);
    card.appendChild(img);
    infoPet.appendChild(type);
    infoPet.appendChild(petDetails);
    infoPet.appendChild(petReward);
    infoPet.appendChild(petZone);

    let contact=document.createElement('div');
    contact.classList.add('contact-info')

    nrTelefonUser.classList.add('nr-tel-user');
    emailUser.classList.add('email-user');

    nrTelefonUser.textContent='Numar de telefon: '+pet.contact.nrTel;
    emailUser.textContent='Email: '+pet.contact.email;

    contact.appendChild(nrTelefonUser);
    contact.appendChild(emailUser);


    let buttons = document.createElement('div')
    buttons.classList.add('buttons');

    let changeLocationButton = document.createElement('button');
    changeLocationButton.textContent = "Change Location";
    changeLocationButton.onclick=function(){changePet(id)}
    buttons.appendChild(changeLocationButton);

    let FoundButton = document.createElement('button');
    FoundButton.textContent = "Found";
    FoundButton.onclick=function(){  foundPet(id)}
    buttons.appendChild(FoundButton);

    
    card.addEventListener('click',function(){ putMarkerAtPetPosition(id)},false);
    card.appendChild(buttons);
    card.appendChild(infoPet);
    card.appendChild(contact);
    cards.appendChild(card);
}

function updatePetsAndNotificationsAndLocation(){
    getActualCoords();
    getAllPets();
    getLostAnimals();
    getNotifications()
}

function createPetsCards(){
    let cards=document.querySelector('div.cards');
    console.log(cards);
    while (cards.firstChild) {
        cards.removeChild(cards.firstChild);
    }
    
        pets.forEach(pet=>
            {
                createPetCard(pet);
            })
    
}

function found(){
    let pet_id=document.getElementById('id_pet_found').value;
    let user_id=document.getElementById('id_user_found').value;
    let location_found=document.getElementById('src_fnd').value;
    let lat_found=document.getElementById('latFound').value;
    let lng_found=document.getElementById('lngFound').value;
    let info={            
        pet_id:pet_id,
        user_id:user_id,
        location_found:location_found,
        lat_found:lat_found,
        lng_found:lng_found
    }
    // console.log(info);
    fetch('/api/markAsFound',{
        method:'POST',
        body:JSON.stringify(info),
        headers: {
            "Content-Type": "application/json"
        }
    }).then(resp=>{
        console.log('this is the jsin',resp);
        return resp.json();})
    .then(resp=>{
        console.log(resp);
        let found = document.getElementById('found-pet');
        found.classList.remove('found-show')
        found.classList.add('found-hidden')
    })
    .catch(err=>{
        console.log("error at: ",err)
    })
    // console.log(pet_id,user_id,location_found,lat_found,lng_found)
}

function changeLocation(){
    let petID = document.getElementById('id_pet_change');
    let latChange = document.getElementById('latChange');
    let lngChange = document.getElementById('lngChange');
    let changeData={
        pet_id:petID.value,
        lat:latChange.value,
        lng:lngChange.value
    }
    console.log(changeData)
    let body=JSON.stringify(changeData);
    // console.log(body)
    fetch('/api/updateLocation',
    {
        method:"POST",
        body:body,
        headers: {
            "Content-Type": "application/json"
        }
    }).then(resp=>resp.json())
    .then(resp=>{console.log(resp)})
    .catch(err=>{console.log("error at: ",err)})
}

function clearMap(mymap){
    if(marker!=undefined)
    {mymap.removeLayer(marker);}
}
function addMarker(lat,lng,mymap){
    marker = L.marker([lat,lng]).addTo(mymap);
    let latLost=document.getElementById('latLostForm')
    let lngLost=document.getElementById('lngLostForm')
    latFound=document.getElementById('latFound')
    lngFound=document.getElementById('lngFound')
    latChange=document.getElementById('latChange')
    lngChange=document.getElementById('lngChange')
    latLost.setAttribute('value',lat);
    lngLost.setAttribute('value',lng);
    latFound.setAttribute('value',lat);
    lngFound.setAttribute('value',lng);
    latChange.setAttribute('value',lat);
    lngChange.setAttribute('value',lng);
    console.log(latLost.value,lngLost.value)
}

getProfilePic();
updatePetsAndNotificationsAndLocation();
setInterval(function(){updatePetsAndNotificationsAndLocation()},10000);
setInterval(function(){createNotification()},3000);
// console.log('Pets in oage :'+petsInPage)