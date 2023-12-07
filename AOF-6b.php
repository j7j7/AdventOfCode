<?php

//Test data
$time = [71530];
$distance = [940200];

//live data
$time = [45988373];
$distance = [295173412781210];

$totalWins[] = 0;
for ($count = 0; $count <= count($time)-1; $count++)
{
    $current_time = $time[$count];
    $current_distance = $distance[$count];

    $wins = 0;

    echo "Time: $current_time | Winning Distance: $current_distance" . "\n";

    for ($i = 0; $i <= $current_time; $i++) {
        $speed = $i;
        $calcDistance = $speed * ($current_time - $i);
        //echo "HoldTime: $i | Distance : $calcDistance  - Result: "; 
        if ($calcDistance > $current_distance) {
            $wins = $wins + 1;
            //echo "Win";
            }
            else {
                //echo "Loose";
            }
            //echo "\n";
        
    }

    echo "Wins : $wins " . "\n";

    if ($wins != 0) {
        $totalWins[] = $wins;
    }
}

print_r( $totalWins);

$totalWinsFinal = 1;
foreach ($totalWins as $win) {
    if ($win != 0) {
        $totalWinsFinal *= $win;
    }
}
echo "Total Wins: " . $totalWinsFinal;
?>