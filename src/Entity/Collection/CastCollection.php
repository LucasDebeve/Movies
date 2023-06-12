<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Cast;

class CastCollection
{
    /** Cherche un film par son id, et retourne tout le cast qui y est associé
     * @param int $id
     * @return array
     */
    public static function findByMovieId(int $id):array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
        SELECT *
        FROM cast
        WHERE movieid = :idMovie
        SQL
        );
        $stmt->execute([":idMovie" => $id]);

        return $stmt->fetchAll(MyPdo::FETCH_CLASS, Cast::class);
    }

    /** Cherche un film par son id, et retourne tout le cast qui y est associé
     * @param int $actorId
     * @return array
     */
    public static function findByPeopleId(int $actorId) : array
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
        SELECT *
        FROM cast
        WHERE peopleid = :idPeople
        SQL
        );
        $stmt->execute([":idPeople" => $actorId]);

        return $stmt->fetchAll(MyPdo::FETCH_CLASS, Cast::class);
    }
}