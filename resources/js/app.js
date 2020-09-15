const { cleanData } = require("jquery");
var Chart = require('chart.js');
var places = require('places.js');
require("./bootstrap");
require("./validation.js")


if($("#search-input").length){
  var placesAutocomplete = places({
    appId: process.env.MIX_APP_ID,
    apiKey: process.env.MIX_API_KEY,
    container: document.querySelector('#search-input'),
  });
}




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

$('.btn-filters-title').on('click', function() {
  $(this).parent(".btn-filters").toggleClass('active');
  $(this).siblings(".filters-search").toggleClass('active');
  $(this).toggleClass('hide');
  $(this).siblings(".btn-filters-close").toggleClass("active")
})

$(".btn-filters-close").on('click', function(){
  $(this).parent(".btn-filters").toggleClass('active');
  $(this).toggleClass("active")
  $(this).siblings(".filters-search").toggleClass('active');
  let title=$(this).siblings(".btn-filters-title");
      title.toggleClass("hide");
//?controllo se ci sono filtri inseriti

  let filters= checkFilters()
  if(filters){
    title.text('Filtri di ricerca attivi!');
  } else {
    title.text('Aggiungi filtri alla ricerca!');
  }

});


function checkFilters(){
  let guestArr=$(".guests-arr");
  let checkbox=$(".filter-checkbox-search");
  let range=$("#radius-range");
  check=false
  guestArr.each(function(){
    if($(this).val() !=0){
      check=true;
      return check
    }
  })
  checkbox.each(function(){
    if ($(this).is(":checked")) {
      check=true;
      return check
    }
  })
  range.each(function(){
    if ($(this).val() !=20) {
      check=true;
      return check
    }
  })

  return check
}
//scrivi valore del range
$("#radius-range").on('change', function() {
    let range = $(this).val();
    $("#range-value").text(range);
});
//Ajax di ricerca in home che ci restituisce coordinate
$("#submit-search").on('click', function() {
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
            document.querySelector('#flatsPromoted-searched').innerHTML='';
            document.querySelector('#flats-searched').innerHTML='';
            
            for (let i = 0; i < flats.length; i++) {
              //?Per ogni appartamento, filtriamo per latitudine longitudine, e i filtri inseriti  
              let flat = filterFlat(lat, lon, services, range, flats[i], guests);
                if (typeof flat != "undefined") {
                  let card = createCard(flat);
                  if(flat.is_promoted){
                    var flatContainer= document.querySelector('#flatsPromoted-searched');
                  }else {
                    var flatContainer=document.querySelector("#flats-searched");
                  }
                    
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
      let flatLat = flat.position.coordinates[1];
      let flatLon = flat.position.coordinates[0];
      let distance = getRadius(lat, flatLat, lon, flatLon);
      if (distance < range && flat.is_hidden != 1) {
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
        detailsButton.classList.add("btn", "btn-primary","details-flat");
        let route = "/flats/" + flat.id; 
        detailsButton.setAttribute("href", route);
        detailsButton.textContent = "Dettagli";
        detailsButton.addEventListener('click', function(){
          ajaxSetView(flat.id);
        })
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

//? mette la classe selected al messaggio cliccato in precedenza nel dropdown
let selectedMsg =$(".message-row-title.selected").data("message")
$(".message-received-content[data-message="+selectedMsg+"]").addClass("active");
$(".message-row-title[data-message="+selectedMsg+"]").removeClass("unread");

//? al click del messaggio nella view index dei messaggi, rende visibile il container del messaggio
$(".message-row-title").click(function(){
  $(".message-row-title").removeClass("selected");
  $(this).addClass("selected");
  if($(this).hasClass("unread")){
    $(this).removeClass("unread");
    ajaxSetRead($(this).data("message"))
  }
  //?se la window è m,aggiore di 770px, rende visibile il container del messaggio che gli è successivo
  if($(document).width() < 770){
    $(this).next(".message-row-content").toggleClass("hide");
    $(".message-received-content").removeClass("active");
    $(".message-received-content[data-message="+ $(this).data("message") +"]").addClass("active");
    //?altrimenti rende visibile il contenuto del messaggio nel box di destra
  } else {
    $(".message-received-content").removeClass("active");
    $(".message-received-content[data-message="+ $(this).data("message") +"]").addClass("active");
  }
})

//?al resize della pagina nascondiamo o mostriamo il box dei messaggi sulla destra
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


function ajaxSetRead(id){
  
  let url= window.location.origin + '/api/messages/'+ id ;
  $.ajax({
    url: url,
    type: "POST",
    
    success: function(result) {
      console.log(result);
      
    },
    error: function(err) {
        console.log(err);
    }
});

}

/* $(".details-flat-home").on('click', '.card-flat',function(){
  let id=$(this).data("flat");
  console.log(id);
  ajaxSetview(id)
}) */


function ajaxSetView(id){
  
  let hiddenAuth=$('.hidden-auth').val();
  let url=window.location.origin + '/api/views/'+ id +'/'+hiddenAuth;
  $.ajax({
    url: url,
    type: "POST",
    success: function(result) {
      console.log(result);
      
    },
    error: function(err) {
        console.log(err);
    }
  });
}


if($('#flat-chart').length){
  ajaxStatistics()
}

$('#flats-chart-select').on('change', function(){
  ajaxStatistics();
})

function ajaxStatistics(){
  let id= $('#flats-chart-select').val()
  let url=window.location.origin + '/api/statistics/'+ id
  $.ajax({
    url: url,
    type: "GET",
    success: function(result) {
      console.log(result);
      makeWeeklyChart(result);
    },
    error: function(err) {
        console.log(err);
    }
  });
}


function makeWeeklyChart(dataObj){
  
  var ctx = document.getElementById('flat-chart');
  let chart = new Chart(ctx, {
    type: 'line',
    data: {
        datasets: [{
            label: 'Visualizzazioni',
            data: dataObj.viewForDay,
            backgroundColor:'rgba(0, 0, 255, 0.5)',
            borderColor:'rgba(0, 0, 255, 0.8)',
            fill:false,
            lineTension:0,
        }],
        labels: dataObj.week
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    suggestedMin: 50,
                    suggestedMax: 100
                }
            }]
        }
    }
  });
}