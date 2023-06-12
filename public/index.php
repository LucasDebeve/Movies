<?php

declare(strict_types=1);

use Entity\Collection\MovieCollection;
use Html\AppWebPage;

$webPage = new AppWebPage("Les films");

$movieCollection = MovieCollection::findAll();

$webPage->appendContent("<div class='list'>");

foreach ($movieCollection as $movie) {
    $webPage->appendContent(<<<HTML
<div class="card">
    <p>{$webPage->escapeString($movie->getTitle())}</p>
</div>
HTML);
}

$webPage->appendContent("</div>");

echo $webPage->toHTML();
