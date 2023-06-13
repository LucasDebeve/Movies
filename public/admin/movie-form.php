<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;
use Entity\Movie;
use Html\Form\MovieForm;

try {
    if (isset($_GET["movieId"])) {
        if (!ctype_digit($_GET["movieId"])) {
            throw new ParameterException("Identifiant du film invalide");
        } else {
            $movie=Movie::findById(intval($_GET["movieId"]));
        }
    } else {
        $movie=null;
    }
    $form=new MovieForm($movie);
    echo $form->getHtmlForm("movie-save.php");
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
