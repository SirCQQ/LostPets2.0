var mymap = L.map('mapid').setView([47.16156163590006, 27.584009170532227], 13);
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    // attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox.streets',
    accessToken: 'pk.eyJ1Ijoic2lyY3FxIiwiYSI6ImNqdmF1bWIyaTFnYWIzeXMxMDBnN21oaDMifQ.fzVeJxr-LkQUfAKR5Tmjhw'
}).addTo(mymap);
mymap.locate({setView:true,maxZoom:16});
mymap.on('click',onMapClick);
var popup = L.popup();
var marker ={}
function onMapClick(e) {
    let form=document.getElementById('input')
    let change=document.getElementById('change-pet')
    let formfound=document.getElementById('found-pet')
    clearMap(mymap);
    if(form.classList[0]==='show-form'|| change.classList[0]==='changeLocation-show' ||formfound.classList[0]==='found-show'){
    addMarker(e.latlng.lat, e.latlng.lng,mymap);
    }
}

function clearMap(mymap){
    if(marker!=undefined)
    {mymap.removeLayer(marker);}
}

function addMarker(lat,lng,mymap){
    marker = L.marker([lat,lng]).addTo(mymap);
    latLost=document.getElementById('latLostForm')
    lngLost=document.getElementById('lngLostForm')
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