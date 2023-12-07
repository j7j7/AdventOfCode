import re

class PosNumber:
    def __init__(self, start_pos, end_pos, line_index, number):
        self.start_pos = start_pos
        self.end_pos = end_pos
        self.line_index = line_index
        self.number = number

def get_lines_from_file(filename):
    with open(filename, 'r') as file:
        return file.readlines()

def find_numbers(line):
    pattern = re.compile(r'\d+')
    matches = pattern.finditer(line)
    return [PosNumber(match.start(), match.end(), 0, int(match.group())) for match in matches]

def symbol_around(number, lines):
    from_index = max(0, number.start_pos - 1)
    to = min(len(lines[0]), number.end_pos + 1)
    for looplines in range(max(0, number.line_index - 1), min(len(lines), number.line_index + 2)):
        if any(c in lines[looplines][from_index:to] for c in "+#$*@/=%-&"):
            return True
    return False

def test_day3_task1():
    lines = get_lines_from_file("day3-test.txt")
    all_numbers = []
    for line_index, line in enumerate(lines):
        numbers_for_line = find_numbers(line)
        for number in numbers_for_line:
            number.line_index = line_index
        all_numbers.extend(numbers_for_line)

    total_sum = sum(number.number for number in all_numbers if symbol_around(number, lines))
    print("totalSum:", total_sum)

def number_touches_symbol(number, line_index, star_pos, number_of_lines):
    for looplines in range(line_index - 1, line_index + 2):
        if looplines < 0 or looplines >= number_of_lines or number.line_index != looplines:
            continue
        if number.start_pos in [star_pos, star_pos + 1] or number.end_pos in [star_pos, star_pos - 1]:
            return True
        if number.line_index != line_index and number.start_pos <= star_pos <= number.end_pos:
            return True
    return False

def find_char_positions(line, target_char):
    return [i for i, char in enumerate(line) if char == target_char]

def test_day3_task2():
    lines = get_lines_from_file("day3-test.txt")
    all_numbers = []
    for line_index, line in enumerate(lines):
        numbers_for_line = find_numbers(line)
        for number in numbers_for_line:
            number.line_index = line_index
        all_numbers.extend(numbers_for_line)

    total_sum = 0
    for line_index, line in enumerate(lines):
        star_positions = find_char_positions(line, '*')
        for star_pos in star_positions:
            found_numbers = [number for number in all_numbers if number_touches_symbol(number, line_index, star_pos, len(lines))]
            #print(":",found_numbers)
            if len(found_numbers) == 2:
                total_sum += found_numbers[0].number * found_numbers[1].number
                print("Found:", found_numbers[0].number, " x ", found_numbers[1].number)

    print("totalSum:", total_sum)

# To run the tests, uncomment the following lines:
# test_day3_task1()
test_day3_task2()
