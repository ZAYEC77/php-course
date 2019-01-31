<?php

session_start();
date_default_timezone_set('Europe/Kiev');

/**
 * Read data from file
 * return empty array if file doesn't exist
 *
 * @param $filename
 * @return array|mixed
 */
function readData($filename)
{
    if (file_exists($filename)) {
        $contents = file_get_contents($filename);
        if ($contents) {
            $data = unserialize($contents);
        } else {
            $data = [];
        }
    } else {
        $data = [];
    }

    return $data;
}

function writeData($filename, $data)
{
    file_put_contents($filename, serialize($data));
}


function hasUser()
{
    return isset($_SESSION['user']);
}


function redirectToHome()
{
    header('Location: ' . getBaseUrl());
    exit;
}

function redirect($to)
{
    header('Location: ' . getBaseUrl() . $to);
    exit;
}


function shortText($text)
{
    if (strlen($text) < 30) {
        return $text;
    }

    return substr($text, 0, 30) . '...';
}

function getUsername()
{
    return $_SESSION['user']['username'];
}

function getBaseUrl()
{
    return '/lesson_10';
}