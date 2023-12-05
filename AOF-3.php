<?php
//test data
$fileContent = "
467..114..
...*......
..35..633.
......#...
617*......
.....+.58.
..592.....
......755.
...$.*....
.664.598..
";

// Initialize variables
$total_sum = 0;
$num = '';
$touches = false;
$lines = explode("\n", trim($fileContent));
$width = strlen($lines[0]);

// Iterate over each line and character in the input
for ($y = 0; $y < count($lines); $y++) {
    for ($x = 0; $x < $width; $x++) {
        $char = $lines[$y][$x];

        // Check if the character is a digit
        if (ctype_digit($char)) {
            $num .= $char; // Append the digit to "num"
            $touches = false; // Assume it doesn't touch a symbol initially

            // Define the relative positions of adjacent cells including diagonals
            $adjacentPositions = [
                [-1, 0], // left
                [1, 0], // right
                [0, -1], // above
                [0, 1], // below
                [-1, -1], // above left
                [1, -1], // above right
                [-1, 1], // below left
                [1, 1], // below right
            ];

            // Check all adjacent positions for a symbol
            foreach ($adjacentPositions as $pos) {
                $adjX = $x + $pos[0];
                $adjY = $y + $pos[1];

                // Check if the adjacent position is within the bounds of the grid
                if ($adjX >= 0 && $adjX < $width && $adjY >= 0 && $adjY < count($lines)) {
                    $adjacentChar = $lines[$adjY][$adjX];
                    // Check if the adjacent character is a symbol
                    if (in_array($adjacentChar, ['*', '+', '#'])) {
                        $touches = true;
                        break;
                    }
                }
            }
        } elseif ($char == '.' || $char == '*' || $char == '+' || $char == '#' || $x == $width - 1) {
            // If touches flag is set and num is not empty
            if ($touches && $num !== '') {
                // Add the value of num to the total_sum
                $total_sum += (int)$num;
            }
            // Reset num and touches for the next number
            $num = '';
            $touches = false;
        }
    }
}

echo "Total sum: " . $total_sum . "\n";
?>