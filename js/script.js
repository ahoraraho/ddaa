var timeLeft = 10;
var elem = document.getElementById("contenr");
var timerId = setInterval(countdown, 1000);

function muestraDiv() {}

//para capturar el elemento que le pertenece a esta
const tipo = document.getElementById("txtpassword");

function erpassword() {
  
  if (tipo.type == "password") {
    tipo.type = "text";
  } else {
    tipo.type = "password";
  }
}
