<?php

$fileContent = "
32T3K 765
T55J5 684
KK677 28
KTJJT 220
QQQJA 483
";

//real data
$fileContent = file_get_contents('day7.txt');

function sortHand($hand) {
    $order = 'AKQJT98765432'; // Define the order from highest to lowest
    $cards = str_split($hand); // Split the hand into individual cards
    usort($cards, function ($a, $b) use ($order) {
        return strpos($order, $a) - strpos($order, $b);
    });
    return implode('', $cards); // Return the sorted hand
}

// Function to assign a numeric strength to each hand type
function getHandStrength($handType) {
    $handStrengths = [
        "Five of a kind" => 7,
        "Four of a kind" => 6,
        "Full house" => 5,
        "Three of a kind" => 4,
        "Two pair" => 3,
        "One pair" => 2,
        "High card" => 1
    ];
    return $handStrengths[$handType] ?? 0;
}

function categorizeHand($hand) {
    $counts = array_count_values(str_split($hand));

    if (in_array(5, $counts)) return "Five of a kind";
    if (in_array(4, $counts)) return "Four of a kind";
    if (in_array(3, $counts) && in_array(2, $counts)) return "Full house";
    if (in_array(3, $counts)) return "Three of a kind";
    if (count($counts) == 3) return "Two pair"; // Three unique card ranks indicate two pairs
    if (count($counts) == 4) return "One pair"; // Four unique cards indicate one pair
    return "High card";
}

$matchedRules = [];

$lines = explode("\n", $fileContent); 
foreach ($lines as $line) {
    $parts = explode(" ", $line);
    if (count($parts) === 2) {
        list($cardInput, $winning) = $parts;
        $sortedHand = sortHand($cardInput); // Sort the hand before matching
        $matchedRule = categorizeHand($sortedHand);
        $matchedRules[] = ["cardInput" => $cardInput, "sortedHand" => $sortedHand, "winning" => $winning, "matchedRule" => $matchedRule];
    }
}

print_r($matchedRules);

// Sort the matched rules by hand strength and then by original hand (cardInput)
usort($matchedRules, function ($a, $b) {
    $strengthComparison = getHandStrength($b['matchedRule']) - getHandStrength($a['matchedRule']);
    if ($strengthComparison === 0) {
        // If hand types are the same, compare the original hands lexicographically
        return strcmp($a['cardInput'], $b['cardInput']);
    }
    return $strengthComparison;
});



// Assign ranks with consideration for duplicates
$totalHands = count($matchedRules);
$rank = $totalHands;
// $previousHandType = '';

// foreach ($matchedRules as $key => $matchedRule) {
//     if ($matchedRule['matchedRule'] !== $previousHandType) {
//         // Assign the current rank and decrement for the next hand
//         $matchedRules[$key]['rank'] = $rank--;
//         $previousHandType = $matchedRule['matchedRule'];
//     } else {
//         // If the hand type is the same as the previous, keep the same rank
//         $matchedRules[$key]['rank'] = $rank;
//     }
// }

// Assign ranks with unique numbers
$rank = $totalHands;
foreach ($matchedRules as $key => $matchedRule) {
    $matchedRules[$key]['rank'] = $rank--; // Assign unique rank to each hand
}

print_r($matchedRules);
// Calculate total winnings
$totalWinnings = 0;
foreach ($matchedRules as $hand) {
    $totalWinnings += intval($hand['winning']) * $hand['rank'];
}


print_r($matchedRules);

echo "Total winnings: " . $totalWinnings . "\n";

?>
