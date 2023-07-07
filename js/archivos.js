const archivos = [{
    archivo: document.getElementById("archivo1"),
    des: document.getElementById("des1"),
    btns: document.querySelectorAll(".btn1")
},
{
    archivo: document.getElementById("archivo2"),
    des: document.getElementById("des2"),
    btns: document.querySelectorAll(".btn2")
},
{
    archivo: document.getElementById("archivo3"),
    des: document.getElementById("des3"),
    btns: document.querySelectorAll(".btn3")
},
{
    archivo: document.getElementById("archivo4"),
    des: document.getElementById("des4"),
    btns: document.querySelectorAll(".btn4")
},
{
    archivo: document.getElementById("archivo5"),
    des: document.getElementById("des5"),
    btns: document.querySelectorAll(".btn5")
},
{
    archivo: document.getElementById("archivo6"),
    des: document.getElementById("des6"),
    btns: document.querySelectorAll(".btn6")
},
{
    archivo: document.getElementById("archivo7"),
    des: document.getElementById("des7"),
    btns: document.querySelectorAll(".btn7")
},
{
    archivo: document.getElementById("archivo8"),
    des: document.getElementById("des8"),
    btns: document.querySelectorAll(".btn8")
}
];

archivos.forEach((item, index) => {
    item.archivo.addEventListener("change", function () {
        if (item.archivo.files.length > 0) {
            const nombre = item.archivo.files[0].name;
            item.des.value = nombre;
            item.btns.forEach((elemento) => {
                elemento.classList.remove("disabled-button");
            });
        } else {
            item.des.value = "";
        }
    });
});


function validateLength(input, maxLength) {
    if (input.value.length > maxLength) {
        input.setCustomValidity("Debe contener " + maxLength + " Caractere(s) como maximo");
    } else {
        input.setCustomValidity("");
    }
}
