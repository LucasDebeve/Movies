<?php


declare(strict_types=1);

use Entity\Collection\GenreMovieCollection;
use Entity\Genre;
use Entity\Movie;
use Exception\ParameterException;
use Html\AppWebPage;

if (empty($_GET['genreId']) || !ctype_digit($_GET['genreId'])) {
    header("Location: /", response_code: 302);
}
$genreId = intval($_GET['genreId']);

$webPage = new AppWebPage();

$genre = Genre::findById($genreId);

$webPage->setTitle("Films du genre " . $genre->getName());

$movies_genres = GenreMovieCollection::findByGenreId($genreId);

$webPage->appendContent("<div class='list'>");

foreach ($movies_genres as $movie_genre) {
    $movie = Movie::findById($movie_genre->getMovieId());
    $strPosterId = strval($movie->getPosterId());
    $webPage->appendContent(<<<HTML
<a href="/movie.php?movieId={$movie->getId()}" class="card">
    <img class="card__img" src="image.php?imageid={$strPosterId}&type=movie" alt="{$movie->getTitle()}">
    <p class="card__desc">{$webPage->escapeString($movie->getTitle())}</p>
</a>
HTML
    );
}

$webPage->appendContent("</div>");

echo $webPage->toHTML();