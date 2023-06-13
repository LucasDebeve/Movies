<?php


declare(strict_types=1);

use Entity\Collection\GenreCollection;
use Entity\Collection\GenreMovieCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Genre;
use Entity\Movie;
use Exception\ParameterException;
use Html\AppWebPage;

$webPage = new AppWebPage();

try {
    if (!isset($_GET["genreId"]) || !ctype_digit($_GET["genreId"])) {
        throw new ParameterException("Identifiant du genre absent ou invalide");
    }
    $genreId = intval($_GET["genreId"]);
    $genre = Genre::findById($genreId);
} catch (ParameterException) {
    header("Location: /", response_code: 302);
    exit();
} catch (EntityNotFoundException) {
    http_response_code(404);
    exit();
}

$webPage->setTitle("Films du genre " . $genre->getName());

$movies_genres = GenreMovieCollection::findByGenreId($genreId);

$webPage->appendContent("<div class='list'>");

foreach ($movies_genres as $movie_genre) {
    $movie = Movie::findById($movie_genre->getMovieId());
    $strPosterId = strval($movie->getPosterId());
    $webPage->appendContent(
        <<<HTML
<a href="/movie.php?movieId={$movie->getId()}" class="card">
    <img class="card__img" src="image.php?imageid={$strPosterId}&type=movie" alt="{$movie->getTitle()}">
    <p class="card__desc">{$webPage->escapeString($movie->getTitle())}</p>
</a>
HTML
    );
}

$webPage->appendContent("</div>");

$webPage->appendToMenu(<<<HTML
<a href="index.php"><span class="menu__detail">Accueil</span><span class="material-symbols-outlined">home</span></a>
HTML);
$webPage->appendToMenu(<<<HTML
<a href="admin/movie-form.php"><span class="menu__detail">Ajouter</span> <span class="material-symbols-outlined">add</span></a>
HTML);
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
