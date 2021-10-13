<?php

declare(strict_types=1);

// Your Code
function readAllTransactionFiles(string $path): array
{
    $fileNames = array_diff(scandir($path), [".", ".."]);
    $transactionsData = [];
    foreach ($fileNames as $fileName) {
        $fileHandle = fopen($path . $fileName, 'r');
        if (!$fileHandle) {
            trigger_error("File '" . $fileName . "' not found", E_USER_ERROR);
        }
        $transactionsData[] = readTransactionFile($fileHandle);
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

function parseAmountToNumber(string $str): float
{
    return (float)str_replace([",", "$"], "", $str);
}

function getTotalIncome(array $transactions): float
{
    $parsedNumbers = array_map(fn($row) => parseAmountToNumber($row["Amount"]), $transactions);
    $positiveNumbers = array_filter($parsedNumbers, fn($num) => $num > 0);
    return array_sum($positiveNumbers);
}


function getTotalExpense(array $transactions): float
{
    $parsedNumbers = array_map(fn($row) => parseAmountToNumber($row["Amount"]), $transactions);
    $negativeNumbers = array_filter($parsedNumbers, fn($num) => $num < 0);
    return array_sum($negativeNumbers);
}

function getNetTotal(array $transactions): float
{
    return getTotalExpense($transactions) + getTotalIncome($transactions);
}