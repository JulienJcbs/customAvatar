<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avatar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div id="avatar" class="position-absolute top-50 start-50 translate-middle">
        <img src="src/color-1.png" class="imgContent" id="color">
        <img src="src/bouche-1.png" class="imgContent" id="bouche">
        <img src="src/yeux-1.png" class="imgContent" id="yeux">
        <img src="" class="imgContent">
        <img src="" class="imgContent">
        <img src="" class="imgContent">
    </div>
    <button id="color" onclick="avatar.nextColor()">Color</button>
    <button id="bouche" onclick="avatar.nextBouche()">Bouche</button>
    <button id="yeux" onclick="avatar.nextYeux()">Yeux</button>
    <form action="#" method="post">
        <input type="hidden" name="color" id="inColor" value="1">
        <input type="hidden" name="bouche" id="inBouche" value="1">
        <input type="hidden" name="yeux" id="inYeux" value="1">
        <button type="submit" name="avatar">Créer</button>
    </form>
    <script src="avatar.js"></script>
</body>

</html>

<?php
if (isset($_POST['avatar'])) {
    // Chargement des images
    $image1 = imagecreatefrompng('src/color-' . $_POST['color'] . '.png');
    $image2 = imagecreatefrompng('src/bouche-' . $_POST['bouche'] . '.png');
    $image3 = imagecreatefrompng('src/yeux-' . $_POST['yeux'] . '.png');

    imagealphablending($image1, false);
    imagesavealpha($image1, true);
    imagealphablending($image2, false);
    imagesavealpha($image2, true);
    imagealphablending($image3, false);
    imagesavealpha($image2, true);

    // Création d'une image vide avec un canal alpha
    $result = imagecreatetruecolor(300, 300);
    imagealphablending($result, false);
    imagesavealpha($result, true);

    // Remplissage de l'image vide avec du transparent
    $transparent = imagecolorallocatealpha($result, 0, 0, 0, 127);
    imagefill($result, 0, 0, $transparent);

    // Fusion de l'image 1 et de l'image 2, 3 dans l'image vide
    imagecopy($result, $image1, 0, 0, 0, 0, 300, 300);

    // Superposition de l'image 2 sur l'image 1 en ignorant les pixels transparents de l'image 2
    for ($x = 0; $x < imagesx($image2); $x++) {
        for ($y = 0; $y < imagesy($image2); $y++) {
            // Récupération de la couleur du pixel courant de l'image 2
            $color = imagecolorat($image2, $x, $y);

            // Récupération des composantes de couleur et d'alpha du pixel courant
            $colors = imagecolorsforindex($image2, $color);

            // Si le pixel n'est pas transparent, on le copie dans l'image de destination
            if ($colors['alpha'] <= 100) {
                imagesetpixel($result, $x, $y, $color);
            }
        }
    }
    // Superposition de l'image 3 sur l'image 1 en ignorant les pixels transparents de l'image 3
    for ($x = 0; $x < imagesx($image3); $x++) {
        for ($y = 0; $y < imagesy($image3); $y++) {
            // Récupération de la couleur du pixel courant de l'image 2
            $color = imagecolorat($image3, $x, $y);

            // Récupération des composantes de couleur et d'alpha du pixel courant
            $colors = imagecolorsforindex($image3, $color);

            // Si le pixel n'est pas transparent, on le copie dans l'image de destination
            if ($colors['alpha'] <= 100) {
                imagesetpixel($result, $x, $y, $color);
            }
        }
    }

    // Envoi de l'image au navigateur
    header('Content-Type: image/png');
    imagepng($result, 'src/bitmoji/avatar.png');

    // Libération de la mémoire
    imagedestroy($image1);
    imagedestroy($image2);
    imagedestroy($image3);
    imagedestroy($result);
}
?>