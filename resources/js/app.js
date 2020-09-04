require("./bootstrap");


/* $('#details-flat').click(function(){
  let lat = $(this).closest('.card-flat').data('lat');
  let lon =  $(this).closest('.card-flat').data('lon');
  console.log(lat + ' ' + lon); */
  
  /* var map = tt.map({
    key: process.env.MIX_TOMTOM_API_KEY,
    container: "map",
    style: "tomtom://vector/1/basic-main",
    center: [33.5555, 12.6667],
    zoom: 13
  }); */
/* }) */

if($('#map').length) {
  let lat = $('.lat').text();
  let lon = $('.lon').text();
  let coordinates=[lon,lat]
  var map = tt.map({
    key: process.env.MIX_TOMTOM_API_KEY,
    container: "map",
    style: "tomtom://vector/1/basic-main",
    
    center: coordinates,
    zoom: 13
  });
}

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



