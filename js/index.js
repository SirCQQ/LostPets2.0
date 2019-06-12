let card= document.querySelectorAll("div.pet-card");
console.log(card);
card.forEach(card=>{
    console.log(card)
    // card.addEventListener
    card.addEventListener('click',onClick);
})

function onClick(e) {
    console.log(e.target.getAttribute('pet_id'));   
    let id=e.target.getAttribute('pet_id');
    let lat,lng;
    let tab=document.querySelectorAll('td');
    for(let i=0;i<tab.length;i++){
        // console.log(td.outerText);
        if(tab[i].outerText===id){
            lat=tab[i+1].outerText;
            lng=tab[i+2].outerText;
            break;
        }
    }
    latP=lat.split(',');
    lngP=lng.split(',');
    lat=latP[0]+'.'+latP[1];
    lng=lngP[0]+'.'+lngP[1];
    // console.log(latP)
    // console.log(id,lat,lng);
    clearMap(mymap);
    addMarker(lat,lng,mymap);
    mymap.setView(L.latLng(lat,lng),16)
    // console.log(e);
}