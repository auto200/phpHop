<?php

declare(strict_types=1);

function formatDate(string $date): string
{
    return date("M j, Y", strtotime($date));
}

function getAmountColor(string $amount): string
{
    return parseAmountToNumber($amount) < 0 ? "red" : "green";
}

function formatNumber(float $number): string
{
    return number_format(abs($number), 2);
}