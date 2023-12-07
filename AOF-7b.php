<?php

$fileContent = "
32T3K 765
T55J5 684
KK677 28
KTJJT 220
QQQJA 483
";

// Real data
 $fileContent = file_get_contents('day7.txt');

$order = 'AKQT98765432J'; // Define the order from highest to lowest

function sortHand($hand) {
    global $order;
    $cards = str_split($hand); // Split the hand into individual cards
    usort($cards, function ($a, $b) use ($order) {
        return strpos($order, $a) - strpos($order, $b);
    });
    return implode('', $cards); // Return the sorted hand
}

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
    global $order;
    $hand = findBestHandWithJokers($hand, $order);

    $counts = array_count_values(str_split($hand));

    if (in_array(5, $counts)) return "Five of a kind";
    if (in_array(4, $counts)) return "Four of a kind";
    if (in_array(3, $counts) && in_array(2, $counts)) return "Full house";
    if (in_array(3, $counts)) return "Three of a kind";
    if (count($counts) == 3) return "Two pair";
    if (count($counts) == 4) return "One pair";
    return "High card";
}

function findBestHandWithJokers($hand, $order) {
    $numJokers = substr_count($hand, 'J');
    if ($numJokers === 0) {
        return $hand; // No Jokers, return the hand as is
    }

    $bestHand = $hand;
    if ($numJokers === 5) {
        $hand = "KKKKK"; // if all jokers - return best hand
        return $hand;
    }

    $bestHandType = categorizeHandWithoutJokers($hand, $order);

    $possibleCards = str_replace('J', '', $order);
    $combinations = generateCombinations($possibleCards, $numJokers);

    foreach ($combinations as $combo) {
        $tempHand = replaceJokers($hand, $combo);
        $tempHandType = categorizeHandWithoutJokers($tempHand, $order);

        if (getHandStrength($tempHandType) > getHandStrength($bestHandType)) {
            $bestHand = $tempHand;
            $bestHandType = $tempHandType;
        }
    }

    return $bestHand;
}

function categorizeHandWithoutJokers($hand, $order) {
    global $order;
    $counts = array_count_values(str_split($hand));

    if (in_array(5, $counts)) return "Five of a kind";
    if (in_array(4, $counts)) return "Four of a kind";
    if (in_array(3, $counts) && in_array(2, $counts)) return "Full house";
    if (in_array(3, $counts)) return "Three of a kind";
    if (count($counts) == 3) return "Two pair";
    if (count($counts) == 4) return "One pair";
    return "High card";
}

function generateCombinations($chars, $size, $combinations = [], $prefix = '') {
    if ($size == 0) {
        $combinations[] = $prefix;
        return $combinations;
    }

    for ($i = 0; $i < strlen($chars); $i++) {
        $newPrefix = $prefix . $chars[$i];
        $combinations = generateCombinations($chars, $size - 1, $combinations, $newPrefix);
    }

    return $combinations;
}

function replaceJokers($hand, $replacement) {
    $resultHand = $hand;
    for ($i = 0; $i < strlen($replacement); $i++) {
        $resultHand = preg_replace('/J/', $replacement[$i], $resultHand, 1);
    }
    return $resultHand;
}

$matchedRules = [];
$lines = explode("\n", $fileContent);
foreach ($lines as $line) {
    $parts = explode(" ", $line);
    if (count($parts) === 2) {
        list($cardInput, $winning) = $parts;
        $sortedHand = sortHand($cardInput);
        $matchedRule = categorizeHand($sortedHand);
        $matchedRules[] = ["cardInput" => $cardInput, "sortedHand" => $sortedHand, "winning" => $winning, "matchedRule" => $matchedRule];
        echo $cardInput . " - $sortedHand - $matchedRule \n";
    }
}

usort($matchedRules, function ($a, $b) use ($order) {
    $strengthComparison = getHandStrength($b['matchedRule']) - getHandStrength($a['matchedRule']);
    if ($strengthComparison === 0) {
        return compareHandsTreatingJAsJ($a['cardInput'], $b['cardInput'], $order);
    }
    return $strengthComparison;
});

// Assign ranks with unique numbers
$totalHands = count($matchedRules);
$rank = $totalHands;
foreach ($matchedRules as $key => &$matchedRule) {
    $matchedRule['rank'] = $rank--; // Assign unique rank to each hand
}

function compareHandsTreatingJAsJ($handA, $handB, $order) {
    // Length of the shorter hand (assuming both hands have the same length after sorting)
    $length = min(strlen($handA), strlen($handB));

    for ($i = 0; $i < $length; $i++) {
        $posA = strpos($order, $handA[$i]);
        $posB = strpos($order, $handB[$i]);

        // Compare card by card
        if ($posA !== $posB) {
            return $posA - $posB;
        }
    }
    // If all compared cards are equal, the hands are considered equal
    return 0;
}


$totalWinnings = 0;
foreach ($matchedRules as $hand) {
    $totalWinnings += intval($hand['winning']) * $hand['rank'];
}

echo "Total winnings: " . $totalWinnings . "\n";

?>
