function change (){
    var card= document.getElementsByClassName("infoNotShow");
    console.log(card)
    
    for(let i=0; i<card.length;i++)
    {card[i].classList.add("infoShow");
    card[i].classList.remove("infoNotShow");
    console.log(card[i])
}
    // card.
}