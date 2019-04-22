function map(){
    let card=document.getElementById("pet-card")
    card.classList.remove("pet-card")
    card.classList.add('hidden');
  
    var mymap = L.map('mapid').setView([47.16252455316927, 27.576370239257812], 13);
    
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
  maxZoom: 18,
   id: 'mapbox.streets'
}).addTo(mymap);

}
