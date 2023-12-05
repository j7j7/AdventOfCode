<?php
//test data
$fileContent = "Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green
Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue
Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red
Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red
Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green
";
// real data
$fileContent = file_get_contents('day2.txt');


$games = explode("\n", $fileContent);
$gametotal =0;
$totalpower = 0;
foreach ($games as $game) {
    if (!empty(trim($game))) {
        $gameParts = explode(": ", $game);
        $gameId = $gameParts[0];
        $rounds = explode("; ", $gameParts[1]);

        $smallestGreen = 0;
        $smallestBlue = 0;
        $smallestRed = 0;
        $roundCount = 0;
        foreach ($rounds as $round) {
            $blueCount = 0;
            $redCount = 0;
            $greenCount = 0;

            $colors = explode(", ", $round);
            foreach ($colors as $color) {
                $colorParts = explode(" ", $color);
                $count = $colorParts[0];
                $colorName = $colorParts[1];

                switch ($colorName) {
                    case 'blue':
                        $blueCount += $count;
                        break;
                    case 'red':
                        $redCount += $count;
                        break;
                    case 'green':
                        $greenCount += $count;
                        break;
                }
            }

            $roundCount++;

            if ($blueCount > $smallestBlue) $smallestBlue = $blueCount; 
            if ($redCount > $smallestRed) $smallestRed = $redCount; 
            if ($greenCount > $smallestGreen) $smallestGreen = $greenCount; 

            echo "In $gameId, round $roundCount, $blueCount blue, $redCount red, and $greenCount green. ";

              echo "\n";
        }
        // work out the power of $smallestBlue, $smallestGreen, $smallestRed by multiplying them together
        $colorCounts = array($smallestBlue, $smallestGreen, $smallestRed);
        rsort($colorCounts); // Sorts the array in descending order        
        $power = $colorCounts[0] * $colorCounts[1] * $colorCounts[2];
        $totalpower = $totalpower + $power;
        echo "In $gameId, $smallestBlue blue, $smallestRed red, and $smallestGreen green. Power = $power"; 
        echo "\n";
        // echo "Game:" . $gameId . " :" .$gamepass;
        // $gameNumber = filter_var($gameID, FILTER_SANITIZE_NUMBER_INT);
        // $gametotal = $gametotal + (int)$gameNumber;
        echo "\n";
    }
}
echo "Total Passed score: " . $totalpower . "\n";
?>