<?php

declare(strict_types=1);

use Entity\Collection\GenreCollection;
use Entity\Collection\MovieCollection;
use Html\AppWebPage;

$webPage = new AppWebPage("Les films");

$webPage->appendToMenu(<<<HTML
<a href="index.php"><span class="menu__detail">Accueil</span><span class="material-symbols-outlined">home</span></a>
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
$webPage->appendToMenu(<<<HTML
<a href="admin/movie-form.php"><span class="menu__detail">Ajouter</span> <span class="material-symbols-outlined">add</span></a>
HTML);

$webPage->appendCssURL("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0");


// Ajout de la barre de recherche
// Drop down list des genres
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

echo $webPage->toHTML();
