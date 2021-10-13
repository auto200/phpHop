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
    return array_merge(...$transactionsData);
}

function readTransactionFile($fileHandle): array
{
    $data = [];

    $row = fgetcsv($fileHandle);
    if (!$row) {
        //file empty
    }

    $columnNames = $row;

    while ($row = fgetcsv($fileHandle)) {
        if (!$row) {
            break;
        }

        $data[] = array_combine($columnNames, $row);
    }

    return $data;
}

$data = readAllTransactionFiles();
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
        foreach (array_keys($data[0]) as $columnName) {
            echo "<th>$columnName</th>";
        }
        ?>
    </tr>
    <?php foreach ($data as $row): ?>
        <tr>
            <td><?php echo date("M d, Y", strtotime($row["Date"])); ?></td>
            <td><?php echo $row["Check #"]; ?></td>
            <td><?php echo $row["Description"]; ?></td>
            <td><?php echo $row["Amount"]; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
