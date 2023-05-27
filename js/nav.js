const body = document.querySelector("body");
const nav = document.querySelector("nav");
const modeToggle = document.querySelector(".dark-light");
const searchToggle = document.querySelector(".searchToggle");
const sidebarOpen = document.querySelector(".sidebarOpen");
const sidebarClose = document.querySelector(".siderbarClose");
const logo = document.querySelector(".logo-img");
const logo2 = document.querySelector(".logg");
const icon = document.querySelector("#iconoTheme");

let getMode = localStorage.getItem("mode");
let getLogo = localStorage.getItem("logo");
const toggleMode = () => {//CONSTANTE PARA HACER LOA CAMBION Y GUARDARLO EN EL LOCAL PARA SU CONSERVACION
  modeToggle.classList.toggle("active");
  body.classList.toggle("dark");

  const mode = body.classList.contains("dark") ? "dark-mode" : "light-mode";
  localStorage.setItem("mode", mode);

  const logoClass = body.classList.contains("dark") ? "logo-dark" : "logo-light";
  localStorage.setItem("logo", logoClass);
  logo.classList.replace(body.classList.contains("dark") ? "logo-light" : "logo-dark", logoClass);
  logo2.classList.replace(body.classList.contains("dark") ? "logo-light" : "logo-dark", logoClass);
}

if (getMode && getMode === "dark-mode" && getLogo === "logo-dark") {
  body.classList.add("dark");
  logo.classList.replace("logo-light", "logo-dark");
  logo2.classList.replace("logo-light", "logo-dark");
}
/*################################################################################################*/
//CAMBIAR EL TEMA DE LA PAGINA Y ICONO GUARDADO EN EL LOCALSTORAGE, OSCURO O CLARO
if (modeToggle) {
  modeToggle.addEventListener("click", toggleMode);
}

if (icon) {
  icon.addEventListener("click", () => {
    if (icon.classList.contains("bi-brightness-high-fill")) {
      localStorage.setItem('classIcon', 'bi-moon');
      icon.classList.replace("bi-brightness-high-fill", "bi-moon");
    } else {
      localStorage.setItem('classIcon', 'bi-brightness-high-fill');
      icon.classList.replace("bi-moon", "bi-brightness-high-fill");
    }
  });
}

if (localStorage.getItem("classIcon")) {
  icon.className = localStorage.getItem("classIcon");
}
/*################################################################################################*/
//BUSCADOR
if (searchToggle) {
  searchToggle.addEventListener("click", () => {
    searchToggle.classList.toggle("active");
  });
}
/*################################################################################################*/
//BOTON DE LISTA DE NAD PARA VISUALISARLO
if (sidebarOpen) {
  sidebarOpen.addEventListener("click", () => {
    if (nav.classList.add("active")) {
      nav.classList.remove("active");
    } else {
      nav.classList.add("active");
    }
  });
}
/*################################################################################################*/
//BOTON DE LISTA DE NAD PARA CERRAR
if (sidebarClose) {
  sidebarClose.addEventListener("click", (e) => {
    let clickedElm = e.target;
    if (
      !clickedElm.classList.contains("sidebarOpen") &&
      !clickedElm.classList.contains("menu")
    ) {
      nav.classList.remove("active");
    }
  });
}

