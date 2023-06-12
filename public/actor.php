<?php
declare(strict_types=1);

use Entity\Collection\CastCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\People;
use Html\AppWebPage;

if (!empty($_GET['actorId']) && ctype_digit($_GET['actorId'])) {
    $actorId = intval($_GET['actorId']);
} else {
    header("Location: /",response_code: 302);
    exit();
}

$webPage = new AppWebPage();

try {
    $actor = People::findByID($actorId);
} catch (EntityNotFoundException $e) {
    http_response_code(404);
    exit();
}

$webPage->setTitle("Films - {$actor->getName()}");

$webPage->appendContent(<<<HTML
<div class="master_card">
    <img src="image.php?imageid={$actor->getAvatarId()}&type=actor" alt="poster">
    <div class="info">
        <h1>{$actor->getName()}</h1>
    <div class='sub_info'>
HTML);
if ($actor->getBirthday() != null ) {
    $webPage->appendContent("<span class='date'>{$actor->getBirthday()}</span>");
} else {
    $webPage->appendContent("<span class='date'>?</span>");
}
if ($actor->getDeathday() != null) {
    $webPage->appendContent("<span class='date'> - {$actor->getBirthday()}</span>");
} else {
    $webPage->appendContent("<span class='date'> - ?</span>");
}
$webPage->appendContent("</div>");

if ($actor->getBiography() != null) {
    $webPage->appendContent("<p class='overview'>{$actor->getBiography()}</p>");
}

$webPage->appendContent(<<<HTML
    </div>
</div>
HTML);

$casts = CastCollection::findByPeopleId($actorId);

echo $webPage->toHTML();