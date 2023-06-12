<?php

declare(strict_types=1);

use Entity\Image;
use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    if(!(!empty($_GET['imageid']) && ctype_digit($_GET['imageid']))) {
        throw new ParameterException("Mauvais paramètre");
    }
    $image = Image::findByID(intval($_GET['imageid']));
    header("Content-Type: image/jpeg");
    echo $image->getJpeg();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    if (!empty($_GET['type']) && ($_GET['type'] === 'movie')) {
        header("Content-Type: image/jpeg");
        echo file_get_contents("static/movie.png");
    } elseif (!empty($_GET['type']) && ($_GET['type'] === 'actor')) {
        header("Content-Type: image/jpeg");
        echo file_get_contents("static/actor.png");
    } else{
        http_response_code(404);
    }
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
