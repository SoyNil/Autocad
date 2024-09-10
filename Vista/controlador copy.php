<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los valores del formulario
    $alto = $_POST['alto'];  // Altura del cubo
    $ancho = $_POST['ancho']; // Ancho de la base
    $largo = $_POST['largo']; // Largo de la base
    $lados = $_POST['lados']; // Número de lados de la base del sólido
    // Crear el script de AutoCAD (archivo .scr)
    $autocadScript = "C:\Users\CONS-ING-04\Documents\Nilton\autocad_script.scr"; // Ajustar ruta

     // Crear contenido del script basado en el número de lados
     $contenido = "";

     if ($lados == 3) {
         // Crear el triángulo de la base en Z=0
    $contenido = "3dface\n";
    $contenido .= "0,0,0\n"; // Vértice 1 en la base
    $contenido .= "$ancho,0,0\n"; // Vértice 2 en la base
    $contenido .= "$ancho,$largo,0\n"; // Vértice 3 en la base
    $contenido .= "\n"; // Línea en blanco para separar los comandos
    
    // Crear el triángulo de la parte superior en Z=$alto
    $contenido .= "3dface\n";
    $contenido .= "0,0,$alto\n"; // Vértice 1 en la parte superior
    $contenido .= "$ancho,0,$alto\n"; // Vértice 2 en la parte superior
    $contenido .= "$ancho,$largo,$alto\n"; // Vértice 3 en la parte superior
    $contenido .= "\n"; // Línea en blanco para separar los comandos
    
    // Conectar la base con la parte superior usando 3dface (caras laterales)
    $contenido .= "3dface\n";
    $contenido .= "0,0,0\n"; // Vértice 1 en la base
    $contenido .= "$ancho,0,0\n"; // Vértice 2 en la base
    $contenido .= "$ancho,0,$alto\n"; // Vértice 2 en la parte superior
    $contenido .= "0,0,$alto\n"; // Vértice 1 en la parte superior
    $contenido .= "\n"; // Línea en blanco para separar los comandos
    
    $contenido .= "3dface\n";
    $contenido .= "$ancho,0,0\n"; // Vértice 1 en la base
    $contenido .= "$ancho,$largo,0\n"; // Vértice 2 en la base
    $contenido .= "$ancho,$largo,$alto\n"; // Vértice 2 en la parte superior
    $contenido .= "$ancho,0,$alto\n"; // Vértice 1 en la parte superior
    $contenido .= "\n"; // Línea en blanco para separar los comandos
    
    $contenido .= "3dface\n";
    $contenido .= "$ancho,$largo,0\n"; // Vértice 1 en la base
    $contenido .= "0,$largo,0\n"; // Vértice 2 en la base
    $contenido .= "0,$largo,$alto\n"; // Vértice 2 en la parte superior
    $contenido .= "$ancho,$largo,$alto\n"; // Vértice 1 en la parte superior
    $contenido .= "\n"; // Línea en blanco para separar los comandos
    
    // Opcional: Centrar la vista para verificar el prisma
    $contenido .= "zoom\n";
    $contenido .= "all\n";
     } elseif ($lados == 4) {
         // Prisma rectangular o cubo (si alto = largo)
         $contenido = "box 0,0 $ancho,$largo $alto\n";
     } elseif ($lados == 5) {
         // Prisma pentagonal
         $contenido = "polygon 5 0,0 10,0 12,8 6,12 -2,8\n";
         $contenido .= "extrude 0,0 10,$alto\n";
     } else {
         // Otros casos o error
         $contenido = "echo 'Número de lados no soportado o figura no implementada'\n";
     } 

    // Guardar el archivo .scr
    file_put_contents($autocadScript, $contenido);

    // Ejecutar AutoCAD y pasar el script
    $comando = 'start "" "C:\Program Files\Autodesk\AutoCAD 2021\acad.exe" /b "'.$autocadScript.'"'; // Ajustar ruta de AutoCAD
    shell_exec($comando);

    echo "AutoCAD iniciado con el proyecto basado en las dimensiones proporcionadas.";
}
?>