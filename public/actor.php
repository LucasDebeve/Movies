<?php

declare(strict_types=1);

use Entity\Collection\CastCollection;
use Entity\Collection\GenreCollection;
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
<a href="index.php"><span class="menu__detail">Accueil</span><span class="material-symbols-outlined">home</span></a>
HTML);

$webPage->appendContent(<<<HTML
<div class="master__card">
    <img src="image.php?imageid={$actor->getAvatarId()}&type=actor" alt="poster">
    <div class="info">
        <h1>{$webPage->escapeString($actor->getName())}</h1>
    <div class='sub_info'>
HTML);
/** Ajout des dates de naissances et de mort : */
if ($actor->getBirthday() != null) {
    $webPage->appendContent("<span class='date'>{$actor->getBirthday()}</span>");
} else {
    $webPage->appendContent("<span class='date'>?</span>");
}
if ($actor->getDeathday() != null) {
    $webPage->appendContent("<span class='date'> - {$actor->getDeathday()}</span>");
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
$films="<div class='list'>";
$duree=0;
foreach ($casts as $cast) {
    try {
        $movie = Movie::findById($cast->getMovieId());
        $duree+=$movie->getRuntime();
        $films=$films.<<<HTML
<a href="movie.php?movieId={$movie->getId()}" class="card">
    <img class="card__img" src="image.php?imageid={$movie->getPosterId()}&type=movie" alt="poster">
    <div class="card__desc">
        <h3>{$webPage->escapeString($movie->getTitle())}</br>({$movie->getReleaseDate()})</h3>
        <p>{$webPage->escapeString($cast->getRole())}</p>
    </div>
</a>
HTML;
    } catch (EntityNotFoundException $e) {
    }
}
$films=$films."</div>";
$nbfilms=count($casts);
$webPage->appendContent("<div class='stats'>");
$webPage->appendContent("<p class='nbMovies'><strong>Nombre de films joués :</strong> {$nbfilms}</p>");
$moyDuree=round($duree/$nbfilms, 2);
$webPage->appendContent("<p class='moyenne__films'><strong>Durée moyenne des films :</strong> {$moyDuree} min</p>");
$webPage->appendContent("</div>");

$webPage->appendContent($films);
// Ajout de la barre de recherche
$webPage->appendToMenu(<<<HTML
<form action="research.php" method="get">
    <select name="genreId">
HTML);
$genres = GenreCollection::findAll();

foreach ($genres as $genre) {
    $webPage->appendToMenu(<<<HTML
        <option value="{$genre->getId()}">{$genre->getName()}</option>
HTML);
}

$webPage->appendToMenu(<<<HTML
    </select>
    <button type="submit">Rechercher</button>
</form>
HTML);

$webPage->appendCssURL("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0");
echo $webPage->toHTML();
