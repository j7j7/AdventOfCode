<?php

$fileContent = "two1nine
eightwothree
abcone2threexyz
xtwone3four
4nineightseven2
zoneight234
7pqrstsixteen
";

echo "Test Case" . "\n";

$lines = explode("\n", $fileContent);
$totalCharValue = 0;
foreach ($lines as $line) {
    if (!empty($line)) {
        $combinedCharValue = decodeString(decodeString2($line));
        echo ":> " . $combinedCharValue . "\n";
        $totalCharValue += intval($combinedCharValue);
    }
}
echo "Total Character value: " . $totalCharValue. "\n";  

//real data
$fileContent = file_get_contents('day1.txt');

echo "\n" . "Real Case" . "\n";
$lines = explode("\n", $fileContent);
$totalCharValue = 0;
foreach ($lines as $line) {
    if (!empty($line)) {
        $combinedCharValue = decodeString2($line);
        $combinedCharValue2 = decodeString($combinedCharValue);
        echo " : > " . $combinedCharValue2 . "\n";
        $totalCharValue += intval($combinedCharValue2);
    }
}
echo "Total Character value: " . $totalCharValue. "\n";  


// get first and last digit, if there is only 1 digit return that twice
function decodeString($str) {
    $firstDigit = null;
    $lastDigit = null;

    for ($i = 0; $i < strlen($str); $i++) {
        if (is_numeric($str[$i])) {
            $firstDigit = $str[$i];
            break;
        }
    }

    for ($i = strlen($str) - 1; $i >= 0; $i--) {
        if (is_numeric($str[$i])) {
            $lastDigit = $str[$i];
            break;
        }
    }

    if ($firstDigit !== null && $lastDigit !== null) {
        if (strlen($str) == 1) {
            return $firstDigit . $firstDigit;
        } else {
            return $firstDigit . $lastDigit;
        }
    } else {
        return -1; // or any other value to indicate an error
    }
}
// turn words into numbers ignore any that are not correct
function decodeString2($str) {
    $words = ["one", "two", "three", "four", "five", "six", "seven", "eight", "nine"];
    $numbers = ["1", "2", "3", "4", "5", "6", "7", "8", "9"];
    $newStr = "";
    echo "Decoding : " . $str;
    for ($i = 0; $i < strlen($str); $i++) {
        if (is_numeric($str[$i])) {
            $newStr .= $str[$i];
            continue;
        }

        $matched = false;
        for ($j = 0; $j < count($words); $j++) {
            $wordLength = strlen($words[$j]);
            if (substr($str, $i, $wordLength) == $words[$j]) {
                $newStr .= $numbers[$j];
                $i += $wordLength - 1;
                $matched = true;
                break;
            }
        }

        if ($matched) {
            // Move the pointer back by one to reuse the letter, if needed
            $i--;
        }
    }
    echo " into: " . $newStr . " | ";
    return $newStr;
}



?>