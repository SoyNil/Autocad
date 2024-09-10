<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los valores del formulario
    $alto = $_POST['alto'];  // Altura del cubo
    $ancho = $_POST['ancho']; // Ancho de la base
    $largo = $_POST['largo']; // Largo de la base

    // Crear el script de AutoCAD (archivo .scr)
    $autocadScript = "C:\Users\Juan\Documents\Autodesskkk\autocad_script.scr"; // Ajustar ruta

    // Crear contenido del script basado en las dimensiones para el cubo
    // Iniciar en la coordenada 0,0,0 y crear un cubo con las dimensiones dadas
    $contenido = "box 0,0,0 $ancho,$largo $alto\n";

    // Guardar el archivo .scr
    file_put_contents($autocadScript, $contenido);

    // Ejecutar AutoCAD y pasar el script
    $comando = 'start "" "C:\Program Files\Autodesk\AutoCAD 2025\acad.exe" /b "'.$autocadScript.'"'; // Ajustar ruta de AutoCAD
    shell_exec($comando);

    echo "AutoCAD iniciado con el proyecto basado en las dimensiones proporcionadas.";
}
?>