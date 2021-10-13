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

function parseAmountToNumber(string $str): float
{
    return (float)str_replace(",", "", str_replace("$", "", $str));
}

function getTotalIncome(array $data): float
{
    $parsedNumbers = array_map(fn($row) => parseAmountToNumber($row["Amount"]), $data);
    $positiveNumbers = array_filter($parsedNumbers, fn($num) => $num > 0);
    return array_sum($positiveNumbers);
}


function getTotalExpense(array $data): float
{
    $parsedNumbers = array_map(fn($row) => parseAmountToNumber($row["Amount"]), $data);
    $negativeNumbers = array_filter($parsedNumbers, fn($num) => $num < 0);
    return array_sum($negativeNumbers);
}

function getAmountColor(string $amount): string
{
    return parseAmountToNumber($amount) < 0 ? "red" : "green";
}

$data = readAllTransactionFiles();
$totalIncome = getTotalIncome($data);
$totalExpense = getTotalExpense($data);

require_once VIEWS_PATH . "transactions.php";
