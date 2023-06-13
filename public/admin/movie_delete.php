<?php

use Entity\Movie;
use Entity\Exception\EntityNotFoundException;

try {
    if (empty($_GET['movieId']) || !ctype_digit($_GET['movieId'])) {
        throw new ParameterException("Identifiant du film absent ou invalide");
    }
    $movieId = intval($_GET['movieId']);
    $movie = Movie::findByID($movieId);
    $movie->delete();
    header("Location: /");
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}