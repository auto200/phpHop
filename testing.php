<?php

declare(strict_types=1);

if (isset($_GET["owner"])) {
    $owner = $_GET["owner"];
    $beersJson = json_decode(file_get_contents("./beers-data.json"));

    $filteredBeers = array_filter(
        $beersJson,
        fn ($beer) =>
        $beer->owner->name === $owner
    );

    echo "<pre>";
    var_dump(json_encode($filteredBeers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    echo "</pre>";
}
