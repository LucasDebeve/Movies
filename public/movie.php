<?php

declare(strict_types=1);

use Entity\Collection\CastCollection;
use Entity\Exception\EntityNotFoundException;
use Html\AppWebPage;
use Entity\Movie;
use Entity\People;

if (!empty($_GET['movieId']) && ctype_digit($_GET['movieId'])) {
    $movieId=intval($_GET['movieId']);
} else {
    header("Location: /", response_code: 302);
    exit();
}

$webPage=new AppWebPage("");

try {
    $movie=Movie::findById($movieId);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit();
}

$webPage->setTitle("Film - {$movie->getTitle()}");
$webPage->appendToMenu(<<<HTML
<a href="index.php">Accueil</a>
HTML);
$webPage->appendCssURL("https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css");

$webPage->appendContent(<<<HTML
<div class="master__card">
    <img src="image.php?imageid={$movie->getPosterId()}&type=movie" alt="poster">
    <div class="info">
        <h1>{$webPage->escapeString($movie->getTitle())}</h1>
        <div class="sub_info">
            <span class="date">{$movie->getReleaseDate()}</span>
HTML);

$languageCountry = ["en" => "gb", "ja" => "jp", "zh" => "cn", "ko" => "kr"];

if (array_key_exists($movie->getOriginalLanguage(), $languageCountry)) {
    $webPage->appendContent("<span class='original_title'><span class='fi fi-{$languageCountry[$movie->getOriginalLanguage()]}'>.</span>{$movie->getOriginalTitle()}</span>");
} else {
    $webPage->appendContent("<span class='original_title'><span class='fi fi-{$movie->getOriginalLanguage()}'>.</span>{$movie->getOriginalTitle()}</span>");
}
$webPage->appendContent("</div>");
if ($movie->getTagline() != null) {
    $webPage->appendContent("<p class='tagline'>{$webPage->escapeString($movie->getTagline())}</p>");
}
if ($movie->getOverview() != null) {
    $webPage->appendContent("<p class='overview'>{$webPage->escapeString($movie->getOverview())}</p>");
}
$webPage->appendContent(<<<HTML
    </div>
</div>
HTML);

$webPage->appendContent("<div class='list__cast'>");
$casts = CastCollection::findByMovieId($movieId);
foreach ($casts as $cast) {
    try {
        $actor = People::findById($cast->getPeopleId());
        $webPage->appendContent(<<<HTML
<a href="actor.php?actorId={$actor->getId()}" class="card card__horizontal">
    <img src="image.php?imageid={$actor->getAvatarId()}&type=actor" alt="poster">
    <div class="info">
        <h3>{$webPage->escapeString($actor->getName())}</h3>
        <span>{$webPage->escapeString($cast->getRole())}</span>
    </div>
</a>
HTML);

    } catch (EntityNotFoundException $e) {
    }

}
$webPage->appendContent("</div>");
$webPage->appendToMenu(<<<HTML
<a href="admin/movie-form.php?movieId={$movie->getId()}">Modifier</a>
<a id="danger" href="admin/movie-delete.php?movieId={$movie->getId()}">Supprimer <span class="material-symbols-outlined">delete</span></a>
HTML);

$webPage->appendCssURL("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0");
echo $webPage->toHTML();
