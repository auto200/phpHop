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

require_once VIEWS_PATH . "transactions.php";
