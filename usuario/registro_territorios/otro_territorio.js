function mostrar_imagen_al_azar() {
    // Array de nombres de archivos de imágenes que tienes en tu carpeta
    var imagenes = ["1.jpg"];

    // Obtiene una imagen al azar del array
    var imagen_al_azar = imagenes[Math.floor(Math.random() * imagenes.length)];

    // Construye la ruta completa de la imagen
    var ruta_completa = "http://localhost/Territorios/usuario/" + imagen_al_azar;

    // Actualiza la fuente de la imagen en la página
    document.getElementById("imagen_mostrada").src = ruta_completa;
}