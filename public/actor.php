<?php

declare(strict_types=1);

use Entity\Collection\CastCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Movie;
use Entity\People;
use Html\AppWebPage;

if (!empty($_GET['actorId']) && ctype_digit($_GET['actorId'])) {
    $actorId = intval($_GET['actorId']);
} else {
    header("Location: /", response_code: 302);
    exit();
}

$webPage = new AppWebPage();

try {
    $actor = People::findByID($actorId);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit();
}

$webPage->setTitle("Films - {$webPage->escapeString($actor->getName())}");

$webPage->appendToMenu(<<<HTML
<a href="index.php">Accueil</a>
HTML);

$webPage->appendContent(<<<HTML
<div class="master__card">
    <img src="image.php?imageid={$actor->getAvatarId()}&type=actor" alt="poster">
    <div class="info">
        <h1>{$webPage->escapeString($actor->getName())}</h1>
    <div class='sub_info'>
HTML);
if ($actor->getBirthday() != null) {
    $webPage->appendContent("<span class='date'>{$actor->getBirthday()}</span>");
} else {
    $webPage->appendContent("<span class='date'>?</span>");
}
if ($actor->getDeathday() != null) {
    $webPage->appendContent("<span class='date'> - {$actor->getBirthday()}</span>");
} else {
    $webPage->appendContent("<span class='date'> - ?</span>");
}
$webPage->appendContent("</div>");

if ($actor->getBiography() != null) {
    $webPage->appendContent("<p class='overview'>{$webPage->escapeString($actor->getBiography())}</p>");
}

$webPage->appendContent(<<<HTML
    </div>
</div>
HTML);

$casts = CastCollection::findByPeopleId($actorId);
$webPage->appendContent("<div class='list'>");
foreach ($casts as $cast) {
    try {
        $movie = Movie::findById($cast->getMovieId());
        $webPage->appendContent(<<<HTML
<a href="movie.php?movieId={$movie->getId()}" class="card">
    <img class="card__img" src="image.php?imageid={$movie->getPosterId()}&type=movie" alt="poster">
    <div class="card__desc">
        <h3>{$webPage->escapeString($movie->getTitle())}</br>({$movie->getReleaseDate()})</h3>
        <p>{$webPage->escapeString($cast->getRole())}</p>
    </div>
</a>
HTML);
    } catch (EntityNotFoundException $e) {
    }
}
$webPage->appendContent("</div>");



echo $webPage->toHTML();
