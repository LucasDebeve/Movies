<?php

declare(strict_types=1);

namespace Html\Form;

use DateTime;
use Entity\Movie;
use Exception\ParameterException;

class MovieForm
{
    use \Html\StringEscaper;

    private ?Movie $movie;

    /** Constructeur de la classe MovieForm
     * @param Movie|null $movie
     */
    public function __construct(?Movie $movie = null)
    {
        $this->movie = $movie;
    }

    /** Accesseur de film
     * @return Movie|null
     */
    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    /** Produit le code HTML du formulaire
     * @param string $action
     * @return string code HTML
     */
    public function getHtmlForm(string $action): string
    {
        if (!is_null($this->movie)) {
            $date=DateTime::createFromFormat("d/m/Y", $this->movie->getReleaseDate())->format("Y-m-d");
            return <<<HTML
<form action="{$action}" method="post" class="full__form">
    <input type="hidden" name="id" id="id" value="{$this->movie->getId()}">
    <label for="title">Titre</label>
    <input type="text" name="title" id="title" value="{$this->escapeString($this->movie->getTitle())}" required>
    <label for="originalLanguage">Langue originale</label>
    <input type="text" name="originalLanguage" id="originalLanguage" value="{$this->escapeString($this->movie->getOriginalLanguage())}" required>
    <label for="originalTitle">Titre original</label>
    <input type="text" name="originalTitle" id="originalTitle" value="{$this->escapeString($this->movie->getOriginalTitle())}" required>
    <label for="releaseDate">Date de sortie</label>
    <input type="date" name="releaseDate" id="releaseDate" value="{$this->escapeString($date)}">
    <label for="runtime">Durée</label>
    <input type="number" name="runtime" id="runtime" value="{$this->escapeString(strval($this->movie->getRuntime()))}">
    <label for="tagline">Tagline</label>
    <input type="text" name="tagline" id="tagline" value="{$this->escapeString($this->movie->getTagline())}">
    <label for="overview">Résumé</label>
    <textarea name="overview" id="overview" cols="30" rows="10">{$this->escapeString($this->movie->getTagline())}</textarea>
    <button type="submit"><span class="menu__detail">Enregistrer</span><span class="material-symbols-outlined">save</span></button>
</form>
HTML;
        } else {
            return <<<HTML
<form action="{$action}" method="post" class="full__form">
    <input type="hidden" name="id" id="id" value="">
    <label for="title">Titre</label>
    <input type="text" name="title" id="title" value="" required>
    <label for="originalLanguage">Langue originale</label>
    <input type="text" name="originalLanguage" id="originalLanguage" value="" required>
    <label for="originalTitle">Titre original</label>
    <input type="text" name="originalTitle" id="originalTitle" value="" required>
    <label for="releaseDate">Date de sortie</label>
    <input type="date" name="releaseDate" id="releaseDate" value="">
    <label for="runtime">Durée</label>
    <input type="number" name="runtime" id="runtime" value="">
    <label for="tagline">Tagline</label>
    <input type="text" name="tagline" id="tagline" value="">
    <label for="overview">Résumé</label>
    <textarea name="overview" id="overview" cols="30" rows="10" style="resize: none"></textarea>
    <button type="submit"><span class="menu__detail">Enregistrer</span><span class="material-symbols-outlined">save</span></button>
</form>
HTML;
        }
    }

    /** Méthode permettant de définir l'attribut $movie à partir des données du formulaire
     * @throws ParameterException
     */
    public function setEntityFromQueryString(): void
    {
        if (!empty($_POST['id']) && ctype_digit($_POST['id'])) {
            $id = intval($_POST['id']);
        } else {
            $id = null;
        }
        if (!empty($_POST['title'])) {
            $title = $this->stripTagsAndTrim($_POST['title']);
        } else {
            throw new ParameterException("Le titre du film non renseigné");
        }
        if (!empty($_POST['originalLanguage'])) {
            $originalLanguage = $this->stripTagsAndTrim($_POST['originalLanguage']);
        } else {
            throw new ParameterException("La langue originale du film non renseignée");
        }
        if (!empty($_POST['originalTitle'])) {
            $originalTitle = $this->stripTagsAndTrim($_POST['originalTitle']);
        } else {
            throw new ParameterException("Le titre original du film non renseigné");
        }
        if (!empty($_POST['releaseDate'])) {
            $releaseDate = str_replace("-", "/", $this->stripTagsAndTrim($_POST['releaseDate']));
            $releaseDate = DateTime::createFromFormat("Y/m/d", $releaseDate)->format("d/m/Y");
        } else {
            $releaseDate=date("d/m/Y");
        }
        if (!empty($_POST['runtime']) && ctype_digit($_POST['runtime'])) {
            $runtime = intval($this->stripTagsAndTrim($_POST['runtime']));
        } else {
            $runtime=0;
        }
        if (!empty($_POST['tagline'])) {
            $tagline = $this->stripTagsAndTrim($_POST['tagline']);
        } else {
            $tagline="";
        }
        if (!empty($_POST['overview'])) {
            $overview = $this->stripTagsAndTrim($_POST['overview']);
        } else {
            $overview="";
        }
        $this->movie = Movie::create($title, $originalTitle, $originalLanguage, $overview, $releaseDate, $runtime, $tagline, $id);

    }

}
