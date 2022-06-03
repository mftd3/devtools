<?php

static $objects;

const SYSTEM_CLASS = [
    'ReflectionMethod',
    'Closure'
];

function parseObject($arg)
{
    global $objects;

    $id = spl_object_id($arg);
    if (isset($objects[$id])) {
        return $id;
    } else {
        $objects[$id] = 1;
    }

    $result = [];

    $reflection = new ReflectionObject($arg);
    $class = $reflection->getName();

    $result['class'] = $class;
    $result['system'] = false;

    if (in_array($class, SYSTEM_CLASS)) {
        $result['system'] = true;
        $objects[$id] = $result;
        return $id;
    }

    $result['file'] = $reflection->getFileName();

    foreach ($reflection->getProperties() as $prop) {
        $key = $prop->getName();
        $value = $prop->getValue($arg);
        $parsed = parse($value);
        $parsed['key'] = $key;
        $result['properties'][] = $parsed;
    }

    if ($objects[$id] === 1) {
        ksort($result);
        $objects[$id] = $result;
    }

    return $id;
}

function parseArray($arg)
{
    $result = [];
    $length = count($arg);
    foreach ($arg as $index => $value) {
        $parsed = parse($value);
        $parsed['key'] = $index;
        $result[] = $parsed;
    }

    return [
        'length' => $length,
        'value' => $result
    ];
}

function parse($arg)
{
    $value = $arg;
    $type = gettype($arg);
    $length = 0;

    if ($type === 'array') {
        $arr =  parseArray($arg);
        $length = $arr['length'];
        $value = $arr['value'];
    } else if ($type === 'object') {
        $value = parseObject($arg);
    } else if ($type === 'string') {
        $length = mb_strlen($value);
    }

    return [
        'type' => $type,
        'length' => $length,
        'value' => $value
    ];
}

function dd(...$args)
{
    global $objects;

    $result = parse(...$args);

    ksort($objects);

    echo json_encode(['objects' => $objects, 'dump' => $result], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

function cors() {

    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

}

cors();