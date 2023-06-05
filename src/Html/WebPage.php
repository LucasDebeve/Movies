<?php

declare(strict_types=1);

namespace Html;

/**
 * Classe WebPage
 */
class WebPage
{
    use \Html\StringEscaper;

    private string $head = '';
    private string $title = '';
    private string $body = '';

    /**
     * Constructeur de la page
     * @param string $title Titre de la page
     */
    public function __construct(string $title = "")
    {
        $this->title = $title;
    }

    /**
     * Accesseur du Head
     * @return string contenu du head
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * Accesseur du Titre
     * @return string titre
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Modificateur du Titre
     * @param string $title nouveau titre
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Accesseur du Body
     * @return string contenu du body
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Ajoute du contenu à Head
     * @param string $content contenu à ajouter
     * @return void
     */
    public function appendToHead(string $content): void
    {
        $this->head .= $content;
    }

    /**
     * Ajoute du style à la page
     * @param string $css Css à ajouter
     * @return void
     */
    public function appendCss(string $css): void
    {
        $this->appendToHead("<style>$css</style>");
    }

    /**
     * Ajoute une feuille de style à la page
     * @param string $url url de la feuille de style
     * @return void
     */
    public function appendCssURL(string $url): void
    {
        $this->appendToHead("<link rel=\"stylesheet\" href=\"$url\">");
    }

    /**
     * Ajoute du javascript
     * @param string $js javascript à ajouté
     * @return void
     */
    public function appendJs(string $js): void
    {
        $this->appendToHead("<script>$js</script>");
    }

    /**
     * Ajoute un script Js
     * @param string $url url du script
     * @return void
     */
    public function appendJsURL(string $url): void
    {
        $this->appendToHead("<script src=\"$url\"></script>");
    }

    /**
     * Ajoute du contenu au body
     * @param string $content contenu à ajouté
     * @return void
     */
    public function appendContent(string $content): void
    {
        $this->body .= $content;
    }

    /**
     * Génère le contenu sous forme HTML
     * @return string code HTML
     */
    public function toHTML(): string
    {
        return <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$this->title}</title>
    {$this->head}
</head>
<body>
    {$this->getBody()}
</body>
</html>
HTML;
    }



    /**
     * Retourne la date de dernière modification
     * @return string Date de dernière modification formatée
     */
    public static function getLastModification(): string
    {
        return date('Y/m/d-H:i:s', getlastmod());
    }
}
