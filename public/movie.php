<?php

declare(strict_types=1);

use Entity\Collection\CastCollection;
use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;
use Entity\Movie;
use Entity\Cast;

if (!empty($_GET['movieId']) && ctype_digit($_GET['movieId'])) {
    $movieid=intval($_GET['movieId']);
} else {
    header("Location: /",response_code: 302);
}
$webPage=new AppWebPage("");
try {
    $movie=Movie::findById($movieid);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit();
}

$webPage->setTitle($movie->getTitle());
$webPage->appendContent("<h1>".$movie->getTitle()."</h1>");
$casts = CastCollection::findByMovieId($movieid);
foreach ($casts as $cast){
    $webPage->appendContent($cast->getRole()."</br>");
}
echo $webPage->toHTML();