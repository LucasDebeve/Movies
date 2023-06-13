<?php

declare(strict_types=1);

namespace Entity;

class GenreMovie
{
    private int $movieId;
    private int $genreId;

    /** Accesseur du movieId
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }

    /** Modifier le movieId
     * @param int $movieId
     * @return GenreMovie
     */
    public function setMovieId(int $movieId): GenreMovie
    {
        $this->movieId = $movieId;
        return $this;
    }

    /** Accesseur du genreId
     * @return int
     */
    public function getGenreId(): int
    {
        return $this->genreId;
    }

    /** Modifier le genreId
     * @param int $genreId
     * @return GenreMovie
     */
    public function setGenreId(int $genreId): GenreMovie
    {
        $this->genreId = $genreId;
        return $this;
    }
}