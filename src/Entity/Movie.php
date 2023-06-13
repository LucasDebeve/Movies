<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

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

    /**
     * @param string $title
     * @return Movie
     */
    public function setTitle(string $title): Movie
    {
        $this->title = $title;
        return $this;
    }

    /** Cherche un film par son id
     * @param int $id
     * @throws EntityNotFoundException
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
            throw new EntityNotFoundException("Film introuvable");
        }
    }

    public function delete() : Movie {
        $stmt = MyPdo::getInstance()->prepare(<<<SQL
DELETE FROM movie
WHERE id = := idMovie
SQL);
        $stmt->execute([":idMovie" => $this->getId()]);
        $this->setId(null);
        return $this;
    }

    public static function create(string $title,string $originalTitle, string $originalLanguage, ?string $overview,
                           string $releaseDate, int $runtime, ?string $tagline, ?int $posterId, ?int $id) : Movie {
        $movie = new self();
        $movie->setTitle($title)->setOriginalTitle($originalTitle)->setOriginalLanguage($originalLanguage)->setOverview($overview);
        return $movie->setReleaseDate($releaseDate)->setRuntime($runtime)->setTagline($tagline)->setPosterId($posterId)->setId($id);
    }

    protected function update(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(<<<SQL
UPDATE artist
SET title = :title,
    originalTitle = :originalTitle,
    originalLanguage = :originalLanguage,
    overview = :overview,
    releaseDate = :releaseDate,
    runtime = :runtime,
    tagline = :tagline,
    posterId = :posterId
WHERE id = :idArtist
SQL);
        $stmt->execute([":idMovie" => $this->id,
            ":name"=>$this->title,
            ":originalTitle"=>$this->originalTitle,
            ":originalLanguage"=>$this->originalLanguage,
            ":overview"=>$this->overview,
            ":releaseDate"=>$this->releaseDate,
            ":runtime"=>$this->runtime,
            ":tagline"=>$this->tagline,
            ":posterId"=>$this->posterId]);
        return $this;
    }

    protected function insert(): Movie
    {
        $stmt = MyPdo::getInstance()->prepare(<<<SQL
INSERT INTO movie (title, originalTitle, originalLanguage, overview, releaseDate, runtime, tagline, posterId)
VALUES (:title, :originalTitle, :originalLanguage, :overview, :releaseDate, :runtime, :tagline, :posterId)
SQL);
        $stmt->execute([":title"=>$this->title,
            ":originalTitle"=>$this->originalTitle,
            ":originalLanguage"=>$this->originalLanguage,
            ":overview"=>$this->overview,
            ":releaseDate"=>$this->releaseDate,
            ":runtime"=>$this->runtime,
            ":tagline"=>$this->tagline,
            ":posterId"=>$this->posterId]);
        $this->setId(intval(MyPdo::getInstance()->lastInsertId()));
        return $this;
    }

    public function save() : Movie {
        if ($this->id) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }
}
