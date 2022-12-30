<?php

function siteUrl($uri = ''): string
{
    return $_ENV['BASE_URL'] . $uri;
}

function redirect($url = '')
{
    header("Location: " . $_ENV['BASE_URL'] . $url);
    exit();
}

function message($msg, $cssClass = '')
{
    echo "<div class='$cssClass' style='padding: 20px; width: 80%; margin: 10px auto; background: #f9dede; border: 1px solid #cca4a4; color: #521717; border-radius: 5px; font-family: sans-serif;'>$msg</div>";
}

// Check if request method is post
function isPostRequest(): bool
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

// Check if request is ajax
function isAjaxRequest(): bool
{
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        return true;
    }

    return false;
}
