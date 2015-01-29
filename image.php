<?php

/*
* USO: <img src="image.php?src=image.jpg&w=100&h=100&filter=grayscale" alt="" />
* El "filter" es opcional.
*/

// add 2

// Despliego en pantalla, en formato JPG
header('Content-Type: image/jpeg');

// Dimensionas solicitadas
$w = $_GET['w']; // Ancho requerido
$h = $_GET['h']; // Alto requerido

// Imagen solicitada
$nombre_archivo = 'archivos/' . $_GET['src'];

// Obtengo las dimensiones de la imagen
list($ancho, $alto) = getimagesize($nombre_archivo);

// Obtengo las nuevas dimensiones

// Para imagenes horizontales
if ($ancho > $alto) {

  $nuevo_ancho = $h * $ancho / $alto; // Achico hasta respetar proporcion con el alto solicitado.
  $nuevo_alto = $h;

  // Calculo la diferencia entre el ancho real y el ancho solicitado,
  // lo divido entre 2, y se lo resto a la posicion x inicial para
  // que quede centrado.
  $diferencia_ancho = ($nuevo_ancho > $w) ? ($ancho - ($alto * $w / $h)) / 2: 0;

// Para imagenes verticales
} else {

  $nuevo_ancho = $w;
  $nuevo_alto = $w * $alto / $ancho;

  // Calculo la diferencia entre el alto real y el alto solicitado,
  // lo divido entre 2, y se lo resto a la posicion y inicial para
  // que quede centrado.
  $diferencia_alto = ($nuevo_alto > $h) ? ($alto - ($ancho * $h / $w)) / 2: 0;

}

// Redimensiono la imagen
$imagen_p = imagecreatetruecolor($w, $h); // Creo una imagen vacia
$imagen = imagecreatefromjpeg($nombre_archivo); // Añado el archivo a la imagen
imagecopyresampled($imagen_p, $imagen, 0, 0, $diferencia_ancho, $diferencia_alto, $nuevo_ancho, $nuevo_alto, $ancho, $alto); // Redimensiono

// Si existe un filtro ($_GET['filter'])
if (isset($_GET['filter'])) {

  $filter = $_GET['filter'];

  // Tengo 3 tipos de filtros:
  switch ($filter) {
    // Muestra en blanco y negro
    case 'grayscale':
      imagefilter($imagen_p, IMG_FILTER_GRAYSCALE);
      break;

    // Muestra "aclarecido"
    case 'brightness':
      imagefilter($imagen_p, IMG_FILTER_COLORIZE, 50, 50, 50);
      break;

    // Muestra oscurecido
    case 'darkness':
    imagefilter($imagen_p, IMG_FILTER_COLORIZE, -45, -45, -45);
      break;
  }
}

// Imprimo la imagen
imagejpeg($imagen_p, null, 100);
?>
