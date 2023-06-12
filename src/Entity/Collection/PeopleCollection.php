<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\People;

class PeopleCollection
{
    /**
     * Une collection de personne est générée avec la méthode `findAll()` de la classe `src/Entity/Collection/PeopleCollection.php`, qui retourne une liste (array) de personnes sous forme d'objects de la classe `src/Entity/People.php`.
     * @return People[]
     */
    public static function findAll()
    {
        $stmt = MyPDO::getInstance()->prepare(
            <<<SQL
            SELECT *
            FROM people
            ORDER BY name
            SQL
        );
        $stmt->execute();
        return $stmt->fetchall(MyPDO::FETCH_CLASS, People::class);
    }
}
