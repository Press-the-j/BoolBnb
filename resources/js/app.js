require("./bootstrap");



/* var map = tt.map({
    key: process.env.MIX_TOMTOM_API_KEY,
    container: "map",
    style: "tomtom://vector/1/basic-main",
    center: [-0.12634, 51.50276],
    zoom: 13
}); */


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


$('#submit-create').click(function(event){ 

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
    success: function(object){
      let result = object.results
   
      let position= getCoordinates(result);
      $('#create-lat').val(position.lat);
      $('#create-long').val(position.lon);
      return
      
    },
    error: function(err){
      console.log(err);
    }
  })


})



function getCoordinates(result) {
  let coordinates =result[0].position;
  return coordinates
}