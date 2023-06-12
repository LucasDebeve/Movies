<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class People
{
    private int $id;
    private ?string $birthday;
    private ?string $deathday;
    private string $name;
    private ?string $biography;
    private ?string $placeOfBirth;
    private ?int $avatarId;

    /**
     * @return int|null
     */
    public function getAvatarId(): ?int
    {
        return $this->avatarId;
    }

    /**
     * @param int|null $avatarId
     * @return People
     */
    public function setAvatarId(?int $avatarId): People
    {
        $this->avatarId = $avatarId;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return People
     */
    public function setId(int $id): People
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /**
     * @param string $birthday
     * @return People
     */
    public function setBirthday(string $birthday): People
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * @return string
     */
    public function getDeathday(): ?string
    {
        return $this->deathday;
    }

    /**
     * @param string $deathday
     * @return People
     */
    public function setDeathday(string $deathday): People
    {
        $this->deathday = $deathday;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return People
     */
    public function setName(string $name): People
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getBiography(): ?string
    {
        return $this->biography;
    }

    /**
     * @param string $biography
     * @return People
     */
    public function setBiography(string $biography): People
    {
        $this->biography = $biography;
        return $this;
    }

    /**
     * @return string
     */
    public function getPlaceOfBirth(): ?string
    {
        return $this->placeOfBirth;
    }

    /**
     * @param string $placeOfBirth
     * @return People
     */
    public function setPlaceOfBirth(string $placeOfBirth): People
    {
        $this->placeOfBirth = $placeOfBirth;
        return $this;
    }
    /** Cherche une personne par son id
     * @param int $id
     * @throws EntityNotFoundException
     * @return People
     */
    public static function findById(int $id): People
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
        SELECT id, avatarId, biography, birthday, deathday, name, placeOfBirth
        FROM people
        WHERE id = :idPeople
        SQL
        );
        $stmt->setFetchMode(MyPdo::FETCH_CLASS, People::class);
        $stmt->execute([":idPeople" => $id]);

        if (($result = $stmt->fetch())) {
            return $result;
        } else {
            throw new EntityNotFoundException("People not found");
        }
    }
}