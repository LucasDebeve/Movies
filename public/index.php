<?php

declare(strict_types=1);

use Entity\Collection\MovieCollection;
use Html\AppWebPage;

$webPage = new AppWebPage("Les films");

$webPage->appendToMenu(<<<HTML
<a href="index.php">Accueil</a>
HTML);

$movieCollection = MovieCollection::findAll();

$webPage->appendContent("<div class='list'>");


foreach ($movieCollection as $movie) {
    $strPosterId = strval($movie->getPosterId());
    $webPage->appendContent(<<<HTML
<a href="/movie.php?movieId={$movie->getId()}" class="card">
    <img class="card__img" src="image.php?imageid={$strPosterId}&type=movie" alt="{$movie->getTitle()}">
    <p class="card__desc">{$webPage->escapeString($movie->getTitle())}</p>
</a>
HTML);
}

$webPage->appendContent("</div>");

echo $webPage->toHTML();
