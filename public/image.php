<?php

declare(strict_types=1);

use Entity\Image;
use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    if(!(!empty($_GET['imageId']) && ctype_digit($_GET['imageId']))) {
        throw new ParameterException("Mauvais paramètre");
    }
    $image = Image::findByID(intval($_GET['imageId']));
    header("Content-Type: image/jpeg");
    echo $image->getJpeg();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
