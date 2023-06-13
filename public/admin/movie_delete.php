<?php

use Entity\Movie;
use Html\AppWebPage;
use Entity\Exception\EntityNotFoundException;

if (!empty($_GET['movieId']) && ctype_digit($_GET['movieId'])) {
    $movieId = intval($_GET['movieId']);
} else {
    header("Location: /", response_code: 302);
    exit();
}

try {
    $movie = Movie::findByID($movieId);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit();
}

$webPage = new AppWebPage();