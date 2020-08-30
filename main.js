var button = document.querySelector(".updatecolor");

var divColorBlue = document.querySelector(".backgroundColorBlue");

button.addEventListener("click", function(){
    divColorBlue.classList.remove("backgroundColorBlue");
    divColorBlue.classList.add("backgroundColorGreen");
});