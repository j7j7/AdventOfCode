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
$fileContent = file_get_contents('day4.txt');

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

    $cards[] = [
        'cardNumber' => $cardNumber,
        'matchingNumbers' => array_filter($matchingNumbers),
        'copies' => 1 // Initialize copies count to 1 for each card
    ];
}

function processCards(&$cards) {
    $totalCards = count($cards);
    for ($i = 0; $i < $totalCards; $i++) {
        $cardValue = count($cards[$i]['matchingNumbers']);
        for ($j = 1; $j <= $cardValue; $j++) {
            $nextCardIndex = $i + $j;
            if ($nextCardIndex < $totalCards) {
                $cards[$nextCardIndex]['copies'] += $cards[$i]['copies'];
            }
        }
    }
}

processCards($cards);

echo "Processed Cards:\n";
$totalCopies = 0;
foreach ($cards as $card) {
    echo $card['cardNumber'] . ": Copies - " . $card['copies'] . "\n";
    $totalCopies += $card['copies'];
}
echo "Total number of scratchcards: " . $totalCopies . "\n";
?>
