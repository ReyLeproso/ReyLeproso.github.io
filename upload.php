<?php
$target_dir = "uploads/";
$uploadOk = 1;

// Verificar si se enviaron archivos
if (!empty($_FILES["file"]["name"])) {
    // Iterar sobre cada archivo
    foreach ($_FILES["file"]["name"] as $key => $name) {
        $target_file = $target_dir . basename($name);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Verificar si el archivo es una imagen real o un archivo falso
        $check = getimagesize($_FILES["file"]["tmp_name"][$key]);
        if ($check !== false) {
            echo "El archivo es una imagen - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "El archivo no es una imagen.";
            $uploadOk = 0;
        }

        // Verificar si el archivo ya existe
        if (file_exists($target_file)) {
            echo "Lo siento, el archivo " . htmlspecialchars(basename($name)) . " ya existe.";
            $uploadOk = 0;
        }

        // Verificar el tamaño del archivo
        if ($_FILES["file"]["size"][$key] > 500000) {
            echo "Lo siento, el archivo " . htmlspecialchars(basename($name)) . " es demasiado grande.";
            $uploadOk = 0;
        }

        // Permitir ciertos formatos de archivo
        $allowedFormats = ["jpg", "jpeg", "png", "gif", "pdf", "doc", "docx", "txt"];
        if (!in_array($imageFileType, $allowedFormats)) {
            echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG, GIF, PDF, DOC y TXT.";
            $uploadOk = 0;
        }

        // Verificar si $uploadOk está configurado en 0 por un error
        if ($uploadOk == 0) {
            echo "Lo siento, tu archivo " . htmlspecialchars(basename($name)) . " no fue subido.";
        } else {
            // Intentar subir el archivo
            if (move_uploaded_file($_FILES["file"]["tmp_name"][$key], $target_file)) {
                echo "El archivo " . htmlspecialchars(basename($name)) . " ha sido subido.";
            } else {
                echo "Lo siento, hubo un error al subir tu archivo " . htmlspecialchars(basename($name)) . ".";
            }
        }
    }
} else {
    echo "No se han enviado archivos.";
}
?>
