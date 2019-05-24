var mymap = L.map('mapid').setView([47.16156163590006, 27.584009170532227], 13);
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    // attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox.streets',
    accessToken: 'pk.eyJ1Ijoic2lyY3FxIiwiYSI6ImNqdmF1bWIyaTFnYWIzeXMxMDBnN21oaDMifQ.fzVeJxr-LkQUfAKR5Tmjhw'
}).addTo(mymap);

var lostmap = L.map('maplost').setView([47.16156163590006, 27.584009170532227], 13);
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    // attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox.streets',
    accessToken: 'pk.eyJ1Ijoic2lyY3FxIiwiYSI6ImNqdmF1bWIyaTFnYWIzeXMxMDBnN21oaDMifQ.fzVeJxr-LkQUfAKR5Tmjhw'
}).addTo(lostmap);
var marker = L.marker([47.16156163590006, 27.584009170532227]).addTo(lostmap);

mymap.locate({setView:true,maxZoom:16});
lostmap.locate({setView:true,maxZoom:16});

// document.getElementById("lostmap").addEventListener()
mymap.on('click',onMapClick);

// function onMapClick(e)
// {   
//     // var marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(mymap);
//     var popul=L.popup.setLanLng(e.latlng).setContent("haha").openOn(mymap);
    
//     console.log(mymap);
// }

var popup = L.popup();
var marker ={}
function onMapClick(e) {
    if(marker!=undefined)
    {mymap.removeLayer(marker);}
   
    // popup
    //     .setLatLng(e.latlng)
    //     .setContent("You clicked the map at " + e.latlng.toString())
    //     .openOn(mymap);
    marker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(mymap);
    console.log("Marker position : lat->"+e.latlng.lat+" lng->"+e.latlng.lng+" !")
}

cards=document.querySelectorAll("div.pet-card");
console.log(cards);
cards.forEach(element => {
    element.addEventListener('click',onClick)
});

function onClick(e){
    console.log(e.path);
}
// console.log(cards[0])
// console.log(cards.length)
// // console.log(cards)
// card=document.querySelector('div.pet-card')
// console.log(card)
