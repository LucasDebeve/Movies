<?php

declare(strict_types=1);

namespace Html;

class AppWebPage extends WebPage
{
    private string $menu = "";

    public function __construct(string $title = "")
    {
        parent::__construct($title);
        $this->appendCssURL("/css/style.css");
    }

    public function appendToMenu(string $menu): void
    {
        $this->menu .= $menu;
    }

    public function toHTML(): string
    {
        $lastModification = parent::getLastModification();
        return <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$this->getTitle()}</title>
    {$this->getHead()}
</head>
<body>
    <header class="header">
        <h1>{$this->getTitle()}</h1>
    </header>
    <nav class="menu">
        {$this->menu}
    </nav>
    <main class="content">
        {$this->getBody()}
    </main>
    <footer class="footer">
    <p>Dernière modification : {$lastModification}</p>
    </footer>
</body>
</html>
HTML;
    }
}
