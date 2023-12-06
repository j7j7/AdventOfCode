<?php
$fileContent = "
Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53
Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19
Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1
Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83
Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36
Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11
";


//real data
//$fileContent = file_get_contents('day4.txt');

$lines = explode("\n", trim($fileContent));
$cards = [];

foreach ($lines as $line) {
    $line = trim($line);
    $parts = explode(":", $line);
    $cardNumber = trim($parts[0]);
    $numbers = explode("|", $parts[1]);
    $winningNumbers = array_map('trim', explode(" ", trim($numbers[0])));
    $yourNumbers = array_map('trim', explode(" ", trim($numbers[1])));

    $matchingNumbers = [];
    foreach ($winningNumbers as $number) {
        if (in_array($number, $yourNumbers)) {
            $matchingNumbers[] = $number;
        }
    }


    $card = [
        'cardNumber' => $cardNumber,
        'winningNumbers' => array_filter($winningNumbers),
        'yourNumbers' => array_filter($yourNumbers),
        'matchingNumbers' => array_filter($matchingNumbers)
    ];
    $cards[] = $card;
}

$jsonData = json_encode($cards, JSON_PRETTY_PRINT);
//echo $jsonData . "\n";


// After processing the first JSON card
$newCardData = [];
foreach ($cards as $index => $card) {
    $newCardData[] = [
        'cardRef' => $index + 1, // Set cardRef as the loop counter
        'cardValue' => count($card['matchingNumbers']),
        'cardFlipped' => false
    ];
}

$newCardJson = json_encode($newCardData, JSON_PRETTY_PRINT);
echo $newCardJson . "\n";


$newCardData = json_decode($newCardJson, true);
$newCards = $newCardData;

$processedCards = [];
$processingRequired = true;
$count = 0;
while ($processingRequired) {
    $processingRequired = false;
    $tempNewCards = $newCards;
    foreach ($newCards as &$card) {
        if (!$card['cardFlipped']) {
            $cardRef = (int)$card['cardRef']; // Explicitly cast to integer
            $cardValue = $card['cardValue'];
            for ($i = 1; $i <= $cardValue; $i++) {
                $nextCardRef = str_pad($cardRef + $i, 2, '0', STR_PAD_LEFT); // Start with the next value
                $tempNewCards[] = [
                    'cardRef' => $nextCardRef,
                    'cardValue' => 0,
                    'cardFlipped' => false
                ];
                $processingRequired = true;
                echo "Created duplicate: " . $nextCardRef . "\n"; // Output the next card reference
            }
            $card['cardFlipped'] = true; // Set current card's cardFlipped to true
            echo "Card flipped : " . $cardRef . "\n";
        }
        $processedCards[] = $card['cardRef'];
        $count ++;
        if ($count > 10000) break;
    }
    $newCards = $tempNewCards;
    unset($card); // Unset reference to last element
}

$newCardData = json_decode($newCardJson, true);
$newCards = $newCardData;

$processedCards = [];
$processingRequired = true;



//echo "Total Cards: " . $TotalCards;
?>