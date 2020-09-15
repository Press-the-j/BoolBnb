$(".title-input").on("change", function (){

})


//? con questa funzione controlliamo che nell'input possa essere scritto solo quello che viene permesso dalla regex;
let inputArr=[".title-input", ".description-input", ".address-input"]

inputArr.forEach(function(element){
  setInputFilter(document.querySelector(element), function (value) {
    return /^[a-zA-Z ,.:\!\? 0-9]*$/.test(value);
  });
})

setInputFilter(document.querySelector(".city-input"), function (value) {
  return /^[a-z A-Z]*$/.test(value);
});

let inputNumberArr=[".postal_code-input", ".square_meters-input", ".max_guest-input", ".rooms-input", ".baths-input"]

inputNumberArr.forEach(function(element){
  setInputFilter(document.querySelector(element), function (value) {
    return /^\d{0,5}$/.test(value);
  });
})

setInputFilter(document.querySelector(".price-input"), function (value) {
  return /^\d{0,4}(?:\.\d{0,2})?$/.test(value);
});

function setInputFilter(textbox, inputFilter) {
  ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function (event) {
    if(textbox){
      textbox.addEventListener(event, function () {
        if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
            this.value = "";
        }
      });
    }  
  });
}
