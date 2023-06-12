<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Movie;

class MovieCollection
{
    /**
     * Une collection d'artiste est générée avec la méthode `findAll()` de la classe `src/Entity/Collection/MovieCollection.php`, qui retourne une liste (array) de films sous forme d'objects de la classe `src/Entity/Movie.php`.
     * @return Movie[]
     */
    public static function findAll()
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM movie
            ORDER BY name
            SQL
        );
        $stmt->execute();
        return $stmt->fetchall(MyPDO::FETCH_CLASS, Movie::class);
    }
}
