<?php
declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Image
{
    private int $id;
    private string $jpeg;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     *
     */
    public static function findById(int $id) : Image {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
        SELECT id, jpeg
        FROM image
        WHERE id = :idImage;
        SQL
        );
        $stmt->execute([":idImage" => $id]);
        $stmt->setFetchMode(MyPdo::FETCH_CLASS, Image::class);
        $result = $stmt->fetch();
        if (!$result) {
            throw new EntityNotFoundException("Image inexistante - id: {$id}");
        } else {
            return $result;
        }
    }
}