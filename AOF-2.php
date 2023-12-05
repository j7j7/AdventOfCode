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
foreach ($games as $game) {
    if (!empty(trim($game))) {
        $gameParts = explode(": ", $game);
        $gameId = $gameParts[0];
        $rounds = explode("; ", $gameParts[1]);

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
            echo "In $gameId, round $roundCount, $blueCount blue, $redCount red, and $greenCount green. ";
            if ($blueCount <=14 and $redCount <=12 and $greenCount <=13) 
            {
                $gamepass = $gameId; //make the $gamepass mark the same as the ID
                echo "- Pass";
             }
              else 
              { 
                $gamepass = 0; //if fails make the $gamepass mark zero
                echo " - Fail";
                break;
              }
              echo "\n";
        }
        echo "\n";
        echo "Game:" . $gameId . " :" .$gamepass;
        $gameNumber = filter_var($gamepass, FILTER_SANITIZE_NUMBER_INT);
        $gametotal = $gametotal + (int)$gameNumber;
        echo "\n";
    }
}
echo "Total Passed score: " . $gametotal . "\n";
?>