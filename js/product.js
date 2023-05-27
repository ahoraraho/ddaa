const seleccionArchivos = document.querySelector("#selectImg"); // Selecciona el elemento con id "selectImg"
const imagenPrevisualizacion = document.querySelector("#previewImg"); // Selecciona el elemento con id "previewImg"

let objectURL;

if (seleccionArchivos) {
    seleccionArchivos.addEventListener("change", () => { // Añade un event listener al elemento "selectImg" para escuchar cuando se cambia la selección de archivos
        if (objectURL) {
            URL.revokeObjectURL(objectURL); // Revoca la URL previa del objeto "objectURL"
        }
        const archivos = seleccionArchivos.files; // Obtiene los archivos seleccionados
        if (!archivos.length) {
            imagenPrevisualizacion.src = ""; // Si no hay archivos seleccionados, establece la src de "previewImg" en una cadena vacía
            return;
        }
        const [primerArchivo] = archivos; // Selecciona el primer archivo
        objectURL = URL.createObjectURL(primerArchivo); // Crea una URL para el primer archivo
        imagenPrevisualizacion.src = objectURL; // Establece la URL como src de "previewImg"
    });

}
