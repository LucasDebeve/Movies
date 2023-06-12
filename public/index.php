<?php

declare(strict_types=1);

use Entity\Collection\MovieCollection;
use Html\AppWebPage;

$webPage = new AppWebPage("Les films");

$movieCollection = MovieCollection::findAll();

$webPage->appendContent("<div class='list'>");


foreach ($movieCollection as $movie) {
    $strPosterId = strval($movie->getPosterId());
    $webPage->appendContent(<<<HTML
<div class="card">
    <img src="image.php?imageid={$strPosterId}&type=movie" alt="{$movie->getTitle()}">
    <p>{$webPage->escapeString($movie->getTitle())}</p>
</div>
HTML);
}

$webPage->appendContent("</div>");

echo $webPage->toHTML();
