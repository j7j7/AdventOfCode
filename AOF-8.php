<?php

$fileContent = "
RL

AAA = (BBB, CCC)
BBB = (DDD, EEE)
CCC = (ZZZ, GGG)
DDD = (DDD, DDD)
EEE = (EEE, EEE)
GGG = (GGG, GGG)
ZZZ = (ZZZ, ZZZ)
";

$fileContent = "
LLR

AAA = (BBB, BBB)
BBB = (AAA, ZZZ)
ZZZ = (ZZZ, ZZZ)
";

$fileContent = file_get_contents('day8.txt');


// Split the content into lines
$lines = explode("\n", $fileContent);

// Initialize an array to hold the processed data
$processedData = [];
$direction = '';

foreach ($lines as $line) {
    // Trim the line to remove unwanted whitespace
    $line = trim($line);

    // Skip empty lines
    if (empty($line)) {
        continue;
    }

// Check if the line contains only RL characters
if (preg_match('/^[RL]+$/', $line)) {
    $direction = $line;
    continue;
}



    // Split the line into components
    $parts = explode(' = ', $line);
    $locationRef = $parts[0];
    $connections = str_replace(['(', ')'], '', $parts[1]);
    $connections = explode(', ', $connections);

    // Store the data in the associative array
    $processedData[$locationRef] = [
        'left' => $connections[0],
        'right' => $connections[1]
    ];
}

// Now $processedData contains the parsed data
print_r($direction);
print("\n");

print_r($processedData);

$steps = 0;

// read the $locationref for each of the $processedData
// decide if the nextLocation is left or right from the $direction character
// if the $direction character is L choose the Left location from the $processedData as the nextLocation to go to
// if the $direction character is R choose the Right location from the $procssedData as the nextLocation to go to
// read the next character from $direction - if it is the last character, loop back to the first character
// continue until the $locationRef = "ZZZ" 
// count how many steps to make it to "ZZZ" 

// Function to find the next location
function getNextLocation($currentLocation, $directionChar, $processedData) {
    return $directionChar == 'L' ? $processedData[$currentLocation]['left'] : $processedData[$currentLocation]['right'];
}

// Start at 'AAA'
$currentLocation = 'AAA';
$steps = 0;
$directionIndex = 0;

while ($currentLocation !== 'ZZZ') {
    $directionChar = $direction[$directionIndex];
    $currentLocation = getNextLocation($currentLocation, $directionChar, $processedData);
    $steps++;

    // Move to the next direction character or loop back
    $directionIndex = ($directionIndex + 1) % strlen($direction);
}

// Output the number of steps
echo "Steps to reach ZZZ: $steps\n";



?>
