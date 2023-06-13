<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use Entity\GenreMovie;

class GenreMovieCollection
{
    public static function findByMovieId(int $movieId): array
    {
        $stmt = MyPdo::getInstance()->prepare(<<<SQL
SELECT * FROM movie_genre WHERE movieid = :movieId
SQL);
        $stmt->execute([":movieId" => $movieId]);
        return $stmt->fetchAll(MyPdo::FETCH_CLASS, GenreMovie::class);
    }

    public static function findByGenreId(int $genreId): array
    {
        $stmt = MyPdo::getInstance()->prepare(<<<SQL
SELECT * FROM movie_genre WHERE genreid = :genreId
SQL);
        $stmt->execute([":genreId" => $genreId]);
        return $stmt->fetchAll(MyPdo::FETCH_CLASS, GenreMovie::class);
    }

}
