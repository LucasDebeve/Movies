<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Genre;

class GenreCollection
{
    public static function findAll() : array
    {
        $stmt = MyPdo::getInstance()->prepare(<<<SQL
SELECT * FROM genre order by name
SQL);
        $stmt->execute();
        return $stmt->fetchAll(MyPdo::FETCH_CLASS, Genre::class);
    }

}