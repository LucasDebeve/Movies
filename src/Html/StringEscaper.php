<?php

namespace Html;

trait StringEscaper
{
    /**
     * Sécurise une chaine de caractère pour le format HTML
     * @param string $string chaine à sécuriser
     * @return string chaine sécurisée
     */
    public function escapeString(?string $string): string
    {
        if (is_null($string)) {
            return "";
        } else {
            return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
    }
    public function stripTagsAndTrim(?string $text)
    {
        if (is_null($text)) {
            return "";
        } else {
            return trim(strip_tags($text));
        }
    }
}
