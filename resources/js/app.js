require("./bootstrap");






if ($("#map").length) {
    let lat = $(".lat").text();
    let lon = $(".lon").text();
    let address = $(".address-flat").text();
    let city = $(".city-flat").text();
    let postalCode = $(".postal_code-flat").text();
    let coordinates = [lon, lat];
    var map = tt.map({
        key: process.env.MIX_TOMTOM_API_KEY,
        container: "map",
        style: "tomtom://vector/1/basic-main",

        center: coordinates,
        zoom: 18
    });
    var marker = new tt.Marker().setLngLat(coordinates).addTo(map);
    var popupOffsets = {
        top: [0, 0],
        bottom: [0, -70],
        "bottom-right": [0, -70],
        "bottom-left": [0, -70],
        left: [25, -35],
        right: [-25, -35]
    };
    var popup = new tt.Popup({ offset: popupOffsets }).setHTML(
        city + " " + address + " " + postalCode
    );
    marker.setPopup(popup).togglePopup();
}

//scrivi valore del range

$("#radius-range").change(function() {
    let range = $(this).val();
    $("#range-value").text(range);
});
//Ajax di ricerca in home che ci restituisce coordinate
$("#submit-search").click(function() {
    let address = $("#search-input").val();
    if (address.length == 0) {
        return;
    }

    $.ajax({
        url: "https://api.tomtom.com/search/2/search/" + address + ".JSON",
        method: "GET",
        data: {
            key: process.env.MIX_TOMTOM_API_KEY,
            countrySet: "IT"
        },
        success: function(object) {
            $(".card-flat").addClass("hide");
            let result = object.results;
            if (!result[0]) {
                $(".alert").removeClass("hide");
                return;
            }
            //!Riceviamo latitudine e longitudine a partire dall'inidirizzo cercato
            let lat = parseFloat(result[0].position.lat);
            let lon = parseFloat(result[0].position.lon);

            //! Prendiamo i valori dei filtri

              //?Filtro del Range
            let distanceRange = parseFloat($("#radius-range").val());

              //?Filtri dei servizi
            let filtersCheck = $(".filter-checkbox-search");

              //creiamo un array di servizi a partire dal filtro  
            let servicesArray = [];
            filtersCheck.each(function() {
                if ($(this).is(":checked")) {
                    servicesArray.push($(this).val());
                }
            });

              //?Filtri ospiti
            let guestsObj = {
              "guests": $('.guests-arr.guests').val(),
              "rooms": $('.guests-arr.rooms').val(),
              "baths": $('.guests-arr.baths').val()
            };
            console.log(guestsObj);
              //Ajax al database
            ajaxFlat(lat, lon, servicesArray, distanceRange, guestsObj);
        },
        error: function(err) {
            console.log(err);
        }
    });
});

//Chiamata Ajax al server per prendere gli appartamenti, richiede:
  //! Latidutine e longitudine
  //! services = Array con i servizi scelti dall'utente
  //! il range di ricerca
  //! guests = Array con i filtri per numero minimo di stanze, bagni e ospiti

function ajaxFlat(lat, lon, services, range, guests ) {
    let url = "api/flats";
    //console.log(services); //!sono quelli che selezioniamo manualmente
    $.ajax({
        url: url,
        method: "GET",
        success: function(result) {
            //?PRendiamo tutti gli appartamneti nel database
            let flats = result.data;
            
            for (let i = 0; i < flats.length; i++) {
                //?Per ogni appartamento, filtriamo per latitudine longitudine, e i filtri inseriti  
                let flat = filterFlat(lat, lon, services, range, flats[i], guests);
                
                if (typeof flat != "undefined") {
                    let card = createCard(flat);
                    let flatContainer = document.querySelector(
                        "#flats-searched"
                    );
                    //console.log(flatContainer);

                    flatContainer.append(card);
                }
            }
            if ($(".flat-searched-container").hasClass("hide")) {
                $(".flat-searched-container").removeClass("hide");
            }
        },
        error: function(err) {
            console.log(err);
        }
    });
}

//quetso è il nostro grande filtro
function filterFlat(lat, lon, services, range, flat, guestsObj) {
    
console.log(flat);
   //? se  l'appartamento non ha un servizio richiest, ci ritorna.
    let flatLat = flat.position.coordinates[1];
    let flatLon = flat.position.coordinates[0];
    for (let i =0; i<services.length; i++){
      if(!flat.services.includes(services[i])){
        return
      }
    }
    
    //?altrimenti filtriamo per il numero minimo di stanze bagni e ospiti
    let minGuests=guestsObj.guests;
    let minRooms=guestsObj.rooms;
    let minBaths=guestsObj.baths;
    if (flat.max_guest >= minGuests && flat.rooms >= minRooms  && flat.baths >= minBaths ) {

      //?e se passa il filtro di prima allora facciamo un filtro per distanza;
        //attraverso la funzione getRadius prendiamo la distanza tra il punto ric3ercato e l'appartamneto, se l'appartamento è compreso nel raggio, non deve essere nascosto  ce lo ritorna
      let distance = getRadius(lat, flatLat, lon, flatLon);
      if (distance < range && flat.is_hidden != 1) {
        console.log('ciao');
          return flat;
      }
    }
    

  }
function createCard(flat) {
  console.log(flat.id+ ' ' + flat.title);
    let cardFlat = document.createElement("div");
        cardFlat.classList.add("card", "card-flat");
        cardFlat.setAttribute("style", "width: 18rem;");
    let cardImage = document.createElement("img");
        cardImage.classList.add("card-img-top");
        cardImage.setAttribute(
          "src",
          flat.image_path ? "../storage/" + flat.image_path : "./img/standard.jpg"
         );
    cardImage.setAttribute("alt", flat.title);

    let cardBody = document.createElement("div");
        cardBody.classList.add("card-body");
    let cardTitle = document.createElement("h5");
        cardTitle.classList.add("card-title");
        cardTitle.textContent = flat.title;

    let cardText = document.createElement("p");
        cardText.classList.add("card-text");
        cardText.textContent = flat.description;
    cardBody.appendChild(cardTitle);
    cardBody.appendChild(cardText);
    let detailsButton = document.createElement("a");
        detailsButton.id = "details-flat";
        detailsButton.classList.add("btn", "btn-primary");
        let route = "/flats/" + flat.id;
        detailsButton.setAttribute("href", route);
        detailsButton.textContent = "Dettagli";
    cardFlat.appendChild(cardImage);
    cardFlat.appendChild(cardBody);
    cardFlat.appendChild(detailsButton);

    return cardFlat;
}



//funzione per trovare radiante delle coordinate
function getRadius(lat1, lat2, lon1, lon2) {
    Number.prototype.toRad = function() {
        return (this * Math.PI) / 180;
    };

    var lat2 = lat2;
    var lon2 = lon2;
    var lat1 = lat1;
    var lon1 = lon1;

    var R = 6371; // km
    //has a problem with the .toRad() method below.
    var x1 = lat2 - lat1;
    var dLat = x1.toRad();
    var x2 = lon2 - lon1;
    var dLon = x2.toRad();
    var a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1.toRad()) *
            Math.cos(lat2.toRad()) *
            Math.sin(dLon / 2) *
            Math.sin(dLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var d = R * c;
    return d;
}
//funzione di prova per tom tom guarda oltre
$("#geocoding").click(function(event) {
    let address = "via del corso Roma 00178";
    $.ajax({
        url: "https://api.tomtom.com/search/2/search/" + address + ".JSON",
        method: "GET",
        data: {
            key: process.env.MIX_TOMTOM_API_KEY,
            countrySet: "IT"
        },
        success: function(object) {
            let result = object.results;
            let position = getCoordinates(result);
        },
        error: function(err) {
            console.log(err);
        }
    });
});

$("#submit-create ").click(function(event) {
    event.preventDefault();
    let street = $("#address-create").val();
    let postalCode = $("#postal_code-create").val();
    let city = $("#city-create").val();

    let address = street + " " + city + " " + postalCode;

    $.ajax({
        url: "https://api.tomtom.com/search/2/search/" + address + ".JSON",
        method: "GET",
        data: {
            key: process.env.MIX_TOMTOM_API_KEY,
            countrySet: "IT"
        },
        success: function(data) {
            let result = data.results;
            let lat = result[0].position.lat;
            let lon = result[0].position.lon;
            $("#create-lat").val(lat);
            $("#create-long").val(lon);
            $("#flats-create").submit();
        },
        error: function(err) {
            console.log(err);
        }
    });
});

$("#submit-edit").click(function(event) {
    event.preventDefault();
    let street = $(" #address-edit").val();
    let postalCode = $(" #postal_code-edit").val();
    let city = $(" #city-edit").val();

    let address = street + " " + city + " " + postalCode;

    $.ajax({
        url: "https://api.tomtom.com/search/2/search/" + address + ".JSON",
        method: "GET",
        data: {
            key: process.env.MIX_TOMTOM_API_KEY,
            countrySet: "IT"
        },
        success: function(data) {
            let result = data.results;
            let lat = result[0].position.lat;
            let lon = result[0].position.lon;
            $(" #edit-lat").val(lat);
            $(" #edit-long").val(lon);
            $("#flats-edit").submit();
        },
        error: function(err) {
            console.log(err);
        }
    });
});


$(".message-row-title").click(function(){
  $(".message-row-title").removeClass("selected");
  $(this).addClass("selected");
  if($(document).width() < 770){
    $(this).next(".message-row-content").toggleClass("hide");
    $(".message-received-content").removeClass("active");
    $(".message-received-content[data-message="+ $(this).data("message") +"]").addClass("active");
  } else {
    console.log($(this).data("message"));
    $(".message-received-content").removeClass("active");
    $(".message-received-content[data-message="+ $(this).data("message") +"]").addClass("active");
  }
})

if($(document).width()>770){
  $(".message-received-box").removeClass("hide");
}

$( window ).resize(function(){
  if($(document).width()>770){
    $(".message-received-box").removeClass("hide");
    $(".message-row-content").addClass("hide");
  } else{
    $(".message-received-box").addClass("hide");
  }
});
/* qui generermo un foreach nell'index con tutti i risultati trovati dalla ricerca della homepage */

/* function generateFlats(lat, lon) {
  let flatsSearchedCont=document.querySelector('#flats-searched'); 
  flatsSearchedCont.innerHTML= '@forelse ($flats as $flat) @if( $flat->position->getLat() <='+ lat + ' 10 || $flat->position->getLat() >='+ lat + '- 10 && $flat->position->getLng() <= ' lon + ' + 10 || $flat->position->getLng() >='+ lon +' - 10)'

  document.querySelector('#flats-searched').append(flatsSearchedCont)
  
} */
