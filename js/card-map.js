

function map(){
    let card=document.getElementById("pet-card")
    let markercount=0;
    var marker;
    console.log(card.children[1])
    card.children[0].classList.remove("pet-img")
    card.children[0].classList.add("none")
    card.children[1].classList.remove("info")
    card.children[1].classList.add("none")
    // card.classList.remove("pet-card")
    // card.classList.remove("pet-img")
    // card.classList.add("pet-img-none")
    // card.classList.add('hidden');
  
    var mymap = L.map('mapid').setView([47.16252455316927, 27.576370239257812], 13);
    
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
  maxZoom: 18,
   id: 'mapbox.streets'
}).addTo(mymap);


function onMapClicked(e) {
  if(markercount===0)
  {marker = L.marker([e.latlng.lat,e.latlng.lng]).addTo(mymap);
    markercount++;
  }
  else 
  {
    mymap.removeLayer(marker)
    marker = L.marker([e.latlng.lat,e.latlng.lng]).addTo(mymap);
    markercount++;
  }
      console.log(e.latlng.lat,e.latlng.lng,markercount);
      // if(markercount>10){ mymap.remove();}
           
}

mymap.on('click', onMapClicked);
console.log(markercount)

}

function closeMap(){
  var mymap = L.map('mapid').setView([47.16252455316927, 27.576370239257812], 13);
  mymap.remove();
}

