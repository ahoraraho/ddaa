const TIMEOUT_OPACITY = 4000;
const TIMEOUT_NONE = 1000;
const div = document.querySelector("#conten-mensaje");
const boton = document.querySelector("#ocultar-mostrar");

const passwordInput = document.getElementById("txtPassword");
const passwordInputOk = document.getElementById("txtPasswordOk");
const passwordInputOdl = document.getElementById("txtPasswordOdl");
const iconEye = document.getElementById("iconoEye");
const iconEyeOk = document.getElementById("iconoEyeOk");
const iconEyeOdl = document.getElementById("iconoEyeOdl");

const botonRegister = document.getElementById("registrar");
const checkboxTerminos = document.getElementById("checkbox");

// Obtener la modal MODAL PREVIE IMAGEN PRODUC
const modal = document.getElementById("myModal");
// Obtenga la imagen e insértela dentro del modal; use su texto "alt" como título	
const img = document.getElementById("myImg");
const modalImg = document.getElementById("img01");
const captionText = document.getElementById("caption");
// Obtener el elemento <span> que cierra el modal
const span = document.getElementsByClassName("close")[0];

// obtenemos el elemento segun al id del boton back
const back = document.getElementById("back");



/*################################################################################################*/
// /* DIV SE CIERRA AUTOMATICAMENTE O AL DARLE CLICK EN CERRAR (ALERTAS)  */
window.addEventListener("load", init);

function init() {
	if (!div || !boton) return;

	div.style.opacity = "1";
	boton.addEventListener("click", hideDivOpacity);
	setTimeout(hideDivOpacity, TIMEOUT_OPACITY);
}

function hideDivOpacity() {
	div.style.opacity = "0";
	setTimeout(hideDivNone, TIMEOUT_NONE);
}
function hideDivNone() {
	div.style.display = "none";
}

// /*################################################################################################*/
// /* VER CONTRASEÑA EN LAS DIFERENTES PARTES DEL...*/
if (iconEye) {
	iconEye.addEventListener("click", function () {
		viewPass(passwordInput, iconEye);
	});
}

if (iconEyeOk) {
	iconEyeOk.addEventListener("click", function () {
		viewPass(passwordInputOk, iconEyeOk);
	});
}

if (iconEyeOdl) {
	iconEyeOdl.addEventListener("click", function () {
		viewPass(passwordInputOdl, iconEyeOdl);
	});
}

function viewPass(imput, iconoEye) {
	imput.type = imput.type === "password" ? "text" : "password";
	iconoEye.classList.toggle("bi-eye");
	iconoEye.classList.toggle("bi-eye-slash");
}

// /*################################################################################################*/
// /*FUNCION PARA VER SI UN BOTON SE PUEDE O NO HACER CLIC DE ACUERDO AL CHECKBOX */
if (checkboxTerminos) {
	checkboxTerminos.addEventListener("click", toggleButtonStatus);
}

function toggleButtonStatus() {
	if (checkboxTerminos.checked) {
		botonRegister.classList.remove("form_singup-disabled");
		botonRegister.classList.add("form_singup");
	} else {
		botonRegister.classList.remove("form_singup");
		botonRegister.classList.add("form_singup-disabled");
	}
}

// /*################################################################################################*/
// /*VUSUALISAR LA IMAGEN EN FORMATO COMPLETO (TODA LA PANTALLA) */
if (img) {
	img.onclick = function () {
		modal.style.display = "block";
		modalImg.src = this.src;
		captionText.innerHTML = this.alt;
	}
}

if (span) {
	// Cuando el usuario hace clic en <span> (x), cierra el modal
	span.onclick = function () {
		modal.style.display = "none";
	}
}



// /*################################################################################################*/
// PARA REGRASAR A LA PAGINA ANTERIOR SEGUN A LA FUNCION DE WINDONS
if (back) {
	back.onclick = function () {
		history.back();
	};
}





