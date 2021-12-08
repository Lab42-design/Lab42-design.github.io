<?php
/**
 * a project skeleton for DarkStar
 */
declare(strict_types = 1);

// date_default_timezone_set('UTC');

// running under built-in server route static assets and return false
if (php_sapi_name() == "cli-server") {
    $extensions = array("php", "jpg", "gif", "css", "png", "js", "ico", "svg");
    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if (in_array($ext, $extensions)) {
        return false;
    }
}

// vendor
require dirname(__DIR__) . '/vendor/autoload.php';

// commencing countdown
require dirname(__DIR__) . '/app/_boot.php';
