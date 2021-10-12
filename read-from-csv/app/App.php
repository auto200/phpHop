<?php

declare(strict_types=1);

// Your Code
function readAllTransactionFiles(): array
{
    $fileNames = array_diff(scandir(FILES_PATH), [".", ".."]);
    $transactionsData = [];
    foreach ($fileNames as $fileName) {
        $fileHandle = fopen(FILES_PATH . $fileName, 'r');
        if ($fileHandle) {
            $transactionsData[] = readTransactionFile($fileHandle);
        }
    }
    return $transactionsData;
}

function readTransactionFile($fileHandle): array
{
    $data = [
        "columnNames" => [],
        "rows" => [],
    ];

    $row = fgetcsv($fileHandle);
    if (!$row) {
        //file empty
    }

    $data["columnNames"] = $row;

    while ($row = fgetcsv($fileHandle)) {
        if (!$row) {
            break;
        }
        $data["rows"][] = $row;
    }

    return $data;
}


$data = readAllTransactionFiles();
$columnNames = $data[0]["columnNames"];
$rows = array_merge(...array_map(fn($asd) => $asd["rows"], $data));
?>

<html lang="en">
<head>
    <title>im reading data from csv file</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<table class="table">
    <tbody>
    <tr>
        <?php
        foreach ($columnNames as $columnName) {
            echo "<th>$columnName</th>";
        }
        ?>
    </tr>
    <?php
    foreach ($rows as $row) {
        echo "<tr>";
        foreach ($row as $cell) {
            echo "<td>$cell</td>";
        }
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
</body>
</html>
