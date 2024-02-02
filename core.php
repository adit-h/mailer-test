<?php

// Dump and Die
function dd($value, $export = false)
{
    echo '<pre>';
    $export ? var_export($value) : var_dump($value);
    exit('</pre>');
}

// RESTful response
function response($data, $status_code = 200)
{
    // List kode status HTTP
    $statuses = [
        200 => 'OK',
        201 => 'Created',
        204 => 'No Content',
        206 => 'Partial Content',

        301 => 'Moved Permanently',
        302 => 'Found',

        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        409 => 'Conflict',
        413 => 'Payload Too Large',
        415 => 'Unsupported Media Type',
        422 => 'Unprocessable Entity',
        429 => 'Too Many Requests',
    ];

    header("{$_SERVER['SERVER_PROTOCOL']} {$status_code} {$statuses[$status_code]}");
    header('Content-Type: application/json');

    echo $data === null ? null : json_encode($data);
}

// Parse input HTTP request
function parse_input($attributes)
{
    $input = json_decode(file_get_contents('php://input'), true);

    // Filter incoming data
    return array_filter($input, function ($key) use ($attributes) {
        return in_array($key, $attributes);
    }, ARRAY_FILTER_USE_KEY);
}
