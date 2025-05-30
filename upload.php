<?php
$uploadDir = __DIR__ . '/uploads/';

// Verifica si se enviaron archivos
if (!isset($_FILES['photos'])) {
    http_response_code(400);
    echo "No se recibieron archivos.";
    exit;
}

// Crea la carpeta si no existe
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        http_response_code(500);
        echo "No se pudo crear la carpeta de destino.";
        exit;
    }
}

foreach ($_FILES['photos']['tmp_name'] as $key => $tmpName) {
    if ($_FILES['photos']['error'][$key] !== UPLOAD_ERR_OK) {
        http_response_code(500);
        echo "Error al subir el archivo.";
        exit;
    }

    $fileName = basename($_FILES['photos']['name'][$key]);
    $targetPath = $uploadDir . time() . '_' . $fileName;

    if (!move_uploaded_file($tmpName, $targetPath)) {
        http_response_code(500);
        echo "Error al mover el archivo.";
        exit;
    }
}

http_response_code(200);
echo "OK";