<?php

declare(strict_types=1);

use Exception\ParameterException;
use Html\Form\MovieForm;

try {
    $form = new MovieForm();
    $form->setEntityFromQueryString();
    $form->getMovie()->save();
    header("Location: /");
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception $e) {
    echo $e->getMessage();
}
