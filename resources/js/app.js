require("./bootstrap");

if($('#map').length) {
  let lat = $('.lat').text();
  let lon = $('.lon').text();
  let address = $('.address-flat').text();
  let city =$('.city-flat').text();
  let postalCode=$('.postal_code-flat').text();
  let coordinates=[lon,lat]
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
    'bottom-right': [0, -70],
    'bottom-left': [0, -70],
    left: [25, -35],
    right: [-25, -35]
  }
  var popup = new tt.Popup({offset: popupOffsets}).setHTML(city + ' ' +  address + ' ' +  postalCode );
  marker.setPopup(popup).togglePopup();
}

//scrivi valore del range

$('#radius-range').change(function (){
  let range = $(this).val();
  $('#range-value').text(range);
})
//Ajax di ricerca in home che ci restituisce coordinate
$('#submit-search').click(function() {
  let address=$('#search-input').val();
  if (address.length == 0){
    
    return 
  }

 $.ajax({
    url: 'https://api.tomtom.com/search/2/search/' + address + '.JSON',
    method: 'GET',
    data:{
      key: process.env.MIX_TOMTOM_API_KEY,
      countrySet: 'IT',
    },
    success: function(object){
      $('.card-flat').addClass('hide')
      let result = object.results
      if (!result[0]){
        
        $('.alert').removeClass('hide');
        return
      }
      let lat=parseFloat(result[0].position.lat);
      let lon=parseFloat(result[0].position.lon);
      let distanceRange=parseFloat($('#radius-range').val())
      let filtersCheck =$('.filter-checkbox-search')
      let servicesArray = []
      filtersCheck.each(function(){
        if($(this).is(':checked')){
          servicesArray.push($(this).val());
        }
      });
        

      $('.flat-searched-container').removeClass('hide');
      let allFlats=$('.card-flat')
      allFlats.each(function(){
        let thisFlatLat=parseFloat($(this).data('lat'));
        let thisFlatLon=parseFloat($(this).data('lon'))
        let distance = getRadius(lat, thisFlatLat, lon, thisFlatLon);
        let flatServices=$(this).find('.data-services')
        let flatServicesArray=[]
        flatServices.each(function () {
          flatServicesArray.push($(this).text())
        })
        console.log(flatServicesArray);
        let includes = compareArray(servicesArray, flatServicesArray);


        if(distance < distanceRange && ) {
          $(this).removeClass('hide');
        }
      })


     /*  for(var i = 0; i<allFlats.length; i++) {
        let thisFlatLat=parseFloat(allFlats[i].getAttribute('data-lat'))
        
        let thisFlatLon=parseFloat(allFlats[i].getAttribute('data-lon'))

        let distance = getRadius(lat, thisFlatLat, lon, thisFlatLon);
       

        if(distance < distanceRange &&  ) {
          allFlats[i].classList.remove('hide');
        }
      } */
    },
    error: function(err){
      console.log(err);
    }
  })
})

function compareArray(arr1, arr2) {
  let includes
  for (let i=0; i<arr1.length; i++){
    let thisService =arr1[i]
    arr2.includes(thisService)
    includes = true;
  }
}



//funzione per trovare radiante delle coordinate
function getRadius(lat1, lat2, lon1, lon2){
Number.prototype.toRad = function() {
  return this * Math.PI / 180;
}

var lat2 = lat2; 
var lon2 = lon2; 
var lat1 = lat1; 
var lon1 = lon1; 

var R = 6371; // km 
//has a problem with the .toRad() method below.
var x1 = lat2-lat1;
var dLat = x1.toRad();  
var x2 = lon2-lon1;
var dLon = x2.toRad();  
var a = Math.sin(dLat/2) * Math.sin(dLat/2) + 
               Math.cos(lat1.toRad()) * Math.cos(lat2.toRad()) * 
               Math.sin(dLon/2) * Math.sin(dLon/2);  
var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
var d = R * c;
return d
}
//funzione di prova per tom tom guarda oltre
$('#geocoding').click(function(event) {
 
  
  let address= 'via del corso Roma 00178';
  $.ajax({
    url: 'https://api.tomtom.com/search/2/search/' + address + '.JSON',
    method: 'GET',
    data:{
      key: process.env.MIX_TOMTOM_API_KEY,
      countrySet: 'IT',
    },
    success: function(object){
      let result = object.results
      let position= getCoordinates(result)
    },
    error: function(err){
      console.log(err);
    }
  })
})


$('#submit-create ').click(function(event){ 
  event.preventDefault()
  let street =  $('#address-create').val();
  let postalCode= $('#postal_code-create').val();
  let city = $('#city-create').val();
  
  
  
  let address= street + ' ' + city + ' '+ postalCode;
  
  $.ajax({
    url: 'https://api.tomtom.com/search/2/search/' + address + '.JSON',
    method: 'GET',
    data:{
      key: process.env.MIX_TOMTOM_API_KEY,
      countrySet: 'IT',
    },
    success: function(data){
        let result = data.results
        let lat=result[0].position.lat;
        let lon= result[0].position.lon
        $('#create-lat').val(lat);
        $('#create-long').val(lon);
        $('#flats-create').submit();
      
    },
    error: function(err){
      console.log(err);
    }
  })

 
})

$('#submit-edit').click(function(event){ 
  event.preventDefault()
  let street =  $(' #address-edit').val();
  let postalCode= $(' #postal_code-edit').val();
  let city = $(' #city-edit').val();
  
  
  
  let address= street + ' ' + city + ' '+ postalCode;
  
  $.ajax({
    url: 'https://api.tomtom.com/search/2/search/' + address + '.JSON',
    method: 'GET',
    data:{
      key: process.env.MIX_TOMTOM_API_KEY,
      countrySet: 'IT',
    },
    success: function(data){
        let result = data.results
        let lat=result[0].position.lat;
        let lon= result[0].position.lon
        $(' #edit-lat').val(lat);
        $(' #edit-long').val(lon);
        $('#flats-edit').submit();
      
    },
    error: function(err){
      console.log(err);
    }
  })

 
})


/* qui generermo un foreach nell'index con tutti i risultati trovati dalla ricerca della homepage */

/* function generateFlats(lat, lon) {
  let flatsSearchedCont=document.querySelector('#flats-searched'); 
  flatsSearchedCont.innerHTML= '@forelse ($flats as $flat) @if( $flat->position->getLat() <='+ lat + ' 10 || $flat->position->getLat() >='+ lat + '- 10 && $flat->position->getLng() <= ' lon + ' + 10 || $flat->position->getLng() >='+ lon +' - 10)'

  document.querySelector('#flats-searched').append(flatsSearchedCont)
  
} */



