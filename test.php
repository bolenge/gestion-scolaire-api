<?php

function get(string $url, array $vars = null, $callback = null)
{
    $curl = curl_init($url);

    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => true
    ]);

    $data = curl_exec($curl);

    if ($data === false || curl_getinfo($curl, CURLINFO_HTTP_CODE) !== 200) {
        $data = null;
    }

    curl_close($curl);
    
    if ($callback !== null) {
        return $callback(json_decode($data), $vars);
    }else {
        return json_decode($data);
    }
}

    header('Locale: fr');

    get('http://localhost:3000/', null, function ($result) {
        print_r($result);
    });