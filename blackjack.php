<?php

// complete all "todo"s to build a blackjack game

// create an array for suits
$suits = ['C', 'H', 'S', 'D'];

// create an array for cards
$cards = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];

// build a deck (array) of cards
// card values should be "VALUE SUIT". ex: "7 H"
// make sure to shuffle the deck before returning it
function buildDeck($suits, $cards) {
  foreach($suits as $suit) {
  	foreach ($cards as $card) {
  		$deck[] = "$card $suit";
  	}
  }
  return $deck;
  //for each suit create a deck of cards with that suit
  //combine all suits into a $deck array
}

// determine if a card is an ace
// return true for ace, false for anything else
function cardIsAce($card) {
  if (substr($card, 0, 1) == 'A') {
  	return true;
  } else {
  	return false;
  }
}

// determine the value of an individual card (string)
// aces are worth 11
// face cards are worth 10
// numeric cards are worth their value
function getCardValue($card) {
  // todo
	$card_value = substr($card, 0, 2);
	switch ($card_value) {
		case 'A ': 
			$value = 11;
			break;
		case 'K ':
			$value = 10;
			break;
		case 'J ':
			$value = 10;
			break;
		case 'Q ':
			$value = 10;
			break;
		default:
			$value = intval($card_value);
			break; 
	}
	// var_dump(substr($card, 0, 2));
	// var_dump($value);
	return $value;
}

// get total value for a hand of cards
// don't forget to factor in aces
// aces can be 1 or 11 (make them 1 if total value is over 21)
function getHandTotal($hand) {
  // todo
	$hand_value = 0;
	foreach ($hand as $card) {
		$hand_value += getCardValue($card); 
	}
	if ($hand_value > 21) {
		$hand_value = 0;
		foreach ($hand as $card) {
			if (cardIsAce($card)) {
				$hand_value += 1;
			} else {
				$hand_value += getCardValue($card);
			}
		}
	}
	return $hand_value;
}

// draw a card from the deck into a hand
// pass by reference (both hand and deck passed in are modified)
function drawCard(&$hand, &$deck) {
	$new_card = array_splice($deck, array_rand($deck), 1);
	$hand[] = $new_card[0];
	// return $hand;
}

// print out a hand of cards
// name is the name of the player
// hidden is to initially show only first card of hand (for dealer)
// output should look like this:
// Dealer: [4 C] [???] Total: ???
// or:
// Player: [J D] [2 D] Total: 12
function echoHand($hand, $name, $hidden = false) {
  echo "$name's hand:" . PHP_EOL;
  $handString = "";
  if ($hidden) {
  	$handString .= $hand[0] . PHP_EOL;
  	} else {
  	foreach ($hand as $key => $card) {
  	$handString .= $card . PHP_EOL;
  	}
  }
  return $handString;
}

function get_input($single_letter = FALSE) {
   //returns single letter input for menus or full strings for any other application
   return ($single_letter ? substr(strtoupper(trim(fgets(STDIN))), 0, 1) : trim(fgets(STDIN)));  
}
// build the deck of cards
$deck = buildDeck($suits, $cards);

// initialize a dealer and player hand
$dealer = [];
$player = [];

// dealer and player each draw two cards
// todo
drawCard($dealer, $deck);
drawCard($dealer, $deck);

drawCard($player, $deck);
drawCard($player, $deck);

// echo the dealer hand, only showing the first card
// todo
echo echoHand($dealer, "Dealer", true);

// echo the player hand
// todo
// echo echoHand($player, "Player", false);

// allow player to "(H)it or (S)tay?" till they bust (exceed 21) or stay
$hand_value = 0;
while ($hand_value < 21) {
  // todo
	echo echoHand($player, "Player");
	echo "(H)it or (S)tay?" . PHP_EOL;
	switch (get_input(true)) {
		case 'H':
			drawCard($player, $deck);
			$hand_value = getHandTotal($player);
			break;

		case 'S':
			$hand_value = 22;
			break;
		
		default:
			echo "Invalid Input" . PHP_EOL;
			break;
	}
}

// show the dealer's hand (all cards)
// todo
echo echoHand($dealer, "Dealer");

// todo (all comments below)

// at this point, if the player has more than 21, tell them they busted
$player_hand_value = getHandTotal($player);
if ($player_hand_value > 21) {
	echo "You busted!" . PHP_EOL;
} elseif ($player_hand_value == 21) {
	echo "You got 21! You win!" . PHP_EOL;
} else {
	$dealer_hand_value = 0;
	while ($dealer_hand_value <= 17) {
		drawCard($dealer, $deck);
		echo echoHand($dealer, "Dealer");
		usleep(5000000);
		$dealer_hand_value = getHandTotal($dealer);
		// var_dump($dealer_hand_value);
	}
	echo echoHand($dealer, "Dealer");
	if ($dealer_hand_value > 21) {
		echo "Dealer busted! You win!" . PHP_EOL;
	} elseif ($player_hand_value == $dealer_hand_value) {
		echo "It's a push! No one wins!" . PHP_EOL;
	} elseif ($player_hand_value < $dealer_hand_value) {
		echo "Dealer wins!" . PHP_EOL;
	} else {
		echo "Player wins!" . PHP_EOL;
	}
}
// otherwise, if they have 21, tell them they won (regardless of dealer hand)

// if neither of the above are true, then the dealer needs to draw more cards
// dealer draws until their hand has a value of at least 17
// show the dealer hand each time they draw a card

// finally, we can check and see who won
// by this point, if dealer has busted, then player automatically wins
// if player and dealer tie, it is a "push"
// if dealer has more than player, dealer wins, otherwise, player wins