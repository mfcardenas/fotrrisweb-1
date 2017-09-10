<?php

$locale = false; // initilize language parameter
// check if getting locale value in query string

if (isset($_GET['lang'])){
    $locale = $_GET['lang'];
    setcookie("lang", $locale);
} else {
    if (isset($_COOKIE['lang'])) {
        $locale = $_COOKIE['lang']; // add selected language in variable
    } else {
        $locale = "en_GB"; // set English US as default language
    }
}



putenv("LANGUAGE=$locale");
setlocale(LC_ALL, $locale);

$domain = "fotrris_messages";
bindtextdomain($domain, "locale");

bind_textdomain_codeset($domain, "UTF-8");

textdomain($domain);
