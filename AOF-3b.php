<?php
function convertToGrid($fileContent) {
    $rows = explode("\n", trim($fileContent));
    $grid = [];
    foreach ($rows as $row) {
        $columns = str_split($row);
        $grid[] = $columns;
    }
    return $grid;
}

function addBlankRow($grid, $width) {
    $blankRow = array_fill(0, $width, '.');
    $grid[] = $blankRow;
    return $grid;
}

function padFileContent($fileContent) {
    $rows = explode("\n", trim($fileContent));
    $paddedContent = "";

    // Add a line with all . at the beginning
    $paddedContent .= str_repeat(".", strlen($rows[0]) + 2) . "\n";

    foreach ($rows as $row) {
        // Add a single . to the start and end of each line
        $paddedContent .= "." . $row . ".\n";
    }

    // Add a line with all . at the end
    $paddedContent .= str_repeat(".", strlen($rows[0]) + 2) . "\n";

    return $paddedContent;
}

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

$paddedContent = padFileContent($fileContent);
echo $paddedContent;

//real data
$fileContent = file_get_contents('day3.txt');

$grid = convertToGrid($fileContent);
$width = count($grid[0]);
$grid = addBlankRow($grid, $width);
$total_sum = 0;
$num = '';
$touches = false;
$height = count($grid);
echo "grid is " . $width . " by " . $height . "\n";

$numberPairs = [];
$starId = 0;
$starNumbers = [];

for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
        $char = $grid[$y][$x];

        if (ctype_digit($char)) {
            $num .= $char;

            $adjacentPositions = [
                [-1, 0], [1, 0], [0, -1], [0, 1], 
                [-1, -1], [1, -1], [-1, 1], [1, 1]
            ];

            foreach ($adjacentPositions as $pos) {
                $adjX = $x + $pos[0];
                $adjY = $y + $pos[1];

                if ($adjX >= 0 && $adjX < $width && $adjY >= 0 && $adjY < $height) {
                    $adjacentChar = $grid[$adjY][$adjX];
                    if ($adjacentChar == '*') {
                        $touches = true;
                        $starId = $adjX . $adjY; // unique id for each star
                    }
                }
            }
        } 

        if (!ctype_digit($char) || $x == $width - 1 || $y == $height - 1) {
            if ($touches && $num !== '') {
                $starNumbers[$starId][] = $num;
            }
            $num = '';
            $touches = false;
        }
    }
}

foreach ($starNumbers as $numbers) {
    if (count($numbers) == 2) {
        $product = $numbers[0] * $numbers[1];
        $total_sum += $product;
        echo $numbers[0] . " * " . $numbers[1] . " = " . $product . "\n";
    } else {
        echo $numbers[0] . " = not a pair, ignore\n";
    }
}

echo "Total sum: " . $total_sum . "\n";
?>