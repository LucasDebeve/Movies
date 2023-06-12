<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;

class Movie
{
    private ?int $id;
    private string $title;
    private string $originalLanguage;
    private string $originalTitle;
    private string $overview;
    private string $releaseDate;
    private int $runtime;
    private string $tagline;
    private int $posterId;

    /**
     * Constructeur privé de Film
     */
    private function __construct()
    {
    }

    /**
     * Accesseur de l'id
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Modificateur de l'id
     * @param int|null $id
     * @return Movie
     */
    private function setId(?int $id): Movie
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Accesseur du titre
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /**
     * @param string $originalLanguage
     * @return Movie
     */
    public function setOriginalLanguage(string $originalLanguage): Movie
    {
        $this->originalLanguage = $originalLanguage;
        return $this;
    }

    /**
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /**
     * @param string $originalTitle
     * @return Movie
     */
    public function setOriginalTitle(string $originalTitle): Movie
    {
        $this->originalTitle = $originalTitle;
        return $this;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @param string $overview
     * @return Movie
     */
    public function setOverview(string $overview): Movie
    {
        $this->overview = $overview;
        return $this;
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @param string $releaseDate
     * @return Movie
     */
    public function setReleaseDate(string $releaseDate): Movie
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    /**
     * @return int
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /**
     * @param int $runtime
     * @return Movie
     */
    public function setRuntime(int $runtime): Movie
    {
        $this->runtime = $runtime;
        return $this;
    }

    /**
     * @return string
     */
    public function getTagline(): string
    {
        return $this->tagline;
    }

    /**
     * @param string $tagline
     * @return Movie
     */
    public function setTagline(string $tagline): Movie
    {
        $this->tagline = $tagline;
        return $this;
    }

    /**
     * @return int
     */
    public function getPosterId(): int
    {
        return $this->posterId;
    }

    /**
     * @param int $poster
     * @return Movie
     */
    public function setPosterId(int $poster): Movie
    {
        $this->posterId = $poster;
        return $this;
    }

    /** Cherche un film par son id
     * @param int $id
     * @throws \Exception
     * @return Movie
     */
    public static function findById(int $id): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(
            <<<SQL
        SELECT *
        FROM movie
        WHERE id = :idMovie
        SQL
        );
        $stmt->setFetchMode(MyPdo::FETCH_CLASS, Movie::class);
        $stmt->execute([":idMovie" => $id]);

        if (($result = $stmt->fetch())) {
            return $result;
        } else {
            throw new \Exception("Movie not found");
        }
    }
}
