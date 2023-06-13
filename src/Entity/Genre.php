<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Genre
{
    private int $id;
    private string $name;

    /** Accesseur de l'id
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /** Accesseur du nom
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public static function findById(int $id): Genre
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
        SELECT id, name
        FROM genre
        WHERE id = :id;
        SQL
        );
        $stmt->setFetchMode(MyPdo::FETCH_CLASS, Genre::class);
        $stmt->execute([":id" => $id]);

        if (($result = $stmt->fetch())) {
            return $result;
        } else {
            throw new EntityNotFoundException("Genre inexistante - id: {$id}");
        }
    }
}
