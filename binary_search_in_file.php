<?php 
// Controls before performing the search
if(empty($argv[1])) {
	die("You must write a key value");
}
if(empty($argv[2])) {
	die("You must indicate the path");
}
if(!file_exists($argv[2])) {
	die("The file doesn't exist");
}

// Get content of the file + get only the words in the file + remove duplicated words in the array
$array = array_unique(str_word_count(file_get_contents($argv[2]), 1));
// Sort array to perform a binary search
sort($array);

/*
 * Recursive binary search algorithm in an array of words
 * @param string $key Value that is searched
 * @param int $start Where to start the search
 * @param int $end Where to end the search
 * @param array $array Array of words
 * @return int Returns the id if it found the key, returns -1 if not
 */
function search($key, $start, $end, $array) {
	if($end < $start) return -1;
	$mid = intval(($start + $end) / 2);
	if($array[$mid] == $key) return $mid;
	if($array[$mid] > $key) $end = $mid - 1;
	if($array[$mid] < $key) $start = $mid + 1;
	return search($key, $start, $end, $array);
}

// Get position of key if it exists
$position = search($argv[1], 0, count($array), $array);
// If it returns -1, display undefined
if($position == -1) die("undefined");
// Display the key
echo $array[$position];