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
                    if (!ctype_digit($adjacentChar) && $adjacentChar != '.') {
                        $touches = true;
                    }
                }
            }
        } 

        if (!ctype_digit($char) || $x == $width - 1 || $y == $height - 1) {
            if ($touches && $num !== '') {
                $total_sum += (int)$num;
                echo $num . "\n";
            }
            $num = '';
            $touches = false;
        }
    }
}

// Check if the last number hasn't been added yet
if ($touches && $num !== '') {
    $total_sum += (int)$num;
    echo $num . "\n";
}

echo "Total sum: " . $total_sum . "\n";

?>