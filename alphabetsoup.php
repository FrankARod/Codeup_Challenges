<?php

function alphabet_soup($str) {
	//creates array of words so they can be altered individually and maintain their order
	$words = explode(" ", $str);
	foreach ($words as $index => $word) {
		//converts strings to arrays of letters so they may be sorted alphabetically
		$letters = str_split($word);
		sort($letters);
		$words[$index] = implode($letters);
	}
	$alphabetized = implode(" ", $words);
	return $alphabetized;
}
	
function get_input($single_letter = FALSE) {
   //returns single letter input for menus or full strings for any other application
   return ($single_letter ? substr(strtoupper(trim(fgets(STDIN))), 0, 1) : trim(fgets(STDIN)));  
 }

do {
	echo "Enter a word to alphabetize!" . PHP_EOL;
	$input = get_input();
	$alphabetized = alphabet_soup($input);
	echo $alphabetized . PHP_EOL;
	
	//Speaks the alphabetized string if used from the Mac
	exec("say -v Alex $alphabetized");
	
	echo "Try another?" . PHP_EOL . "Type any key to continue or (N)o to quit" . PHP_EOL;
	
	//loop allows user to rerun the application until they get bored
	switch (get_input(true)) {
		case 'N':
			$again = false;
			echo "Goodbye!" . PHP_EOL;
			break;
		
		default:
			$again = true;
			break;
	}		
} while ($again);