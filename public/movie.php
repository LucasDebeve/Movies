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
    header("Location: /",response_code: 302);
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

$webPage->appendCssURL("https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css");

$webPage->appendContent(<<<HTML
<div class="master_card">
    <img src="image.php?imageid={$movie->getPosterId()}&type=movie" alt="poster">
    <div class="info">
        <h1>{$webPage->escapeString($movie->getTitle())}</h1>
        <div class="sub_info">
            <span class="date">{$movie->getReleaseDate()}</span>
            <span class="original_title"><span class="fi fi-{$webPage->escapeString($movie->getOriginalLanguage())}">.</span>{$webPage->escapeString($movie->getOriginalTitle())}</span>
        </div>
HTML);
if ($movie->getTagline() != null ) {
    $webPage->appendContent("<p class='tagline'>{$webPage->escapeString($movie->getTagline())}</p>");
}
if ($movie->getOverview() != null) {
    $webPage->appendContent("<p class='overview'>{$webPage->escapeString($movie->getOverview())}</p>");
}
$webPage->appendContent(<<<HTML
    </div>
</div>
HTML);

$webPage->appendContent("<div class='list'>");
$casts = CastCollection::findByMovieId($movieId);
foreach ($casts as $cast){
    try {
        $actor = People::findById($cast->getPeopleId());
        $webPage->appendContent(<<<HTML
<div class="card card__horizontal">
    <img src="image.php?imageid={$actor->getAvatarId()}&type=actor" alt="poster">
    <div class="info">
        <p>{$webPage->escapeString($cast->getRole())}</p>
        <p>{$webPage->escapeString($actor->getName())}</p>
    </div>
</div>
HTML);

    } catch (EntityNotFoundException $e) {
    }

}
$webPage->appendContent("</div>");

echo $webPage->toHTML();