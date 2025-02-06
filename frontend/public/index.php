<?php

header('Content-Type: application/json');

// Function to generate a deck of 52 cards
function generateDeck() {
    $suits = ['S', 'H', 'D', 'C']; // Spades, Hearts, Diamonds, Clubs
    $ranks = ['A', '2', '3', '4', '5', '6', '7', '8', '9', 'X', 'J', 'Q', 'K']; // Cards 1 to 13
    
    $deck = [];
    foreach ($suits as $suit) {
        foreach ($ranks as $rank) {
            $deck[] = $suit . '-' . $rank; // Create card like 'S-A', 'H-2', etc.
        }
    }
    return $deck;
}

// Shuffle the deck
function shuffleDeck($deck) {
    shuffle($deck); // Shuffle the deck randomly
    return $deck;
}

// Function to distribute the cards to n people
function distributeCards($numPeople) {
    if ($numPeople <= 0 || $numPeople > 52) {
        return "Input value does not exist or value is invalid";
    }
    
    $deck = generateDeck(); // Generate the deck
    $deck = shuffleDeck($deck); // Shuffle the deck
    
    // Distribute the cards to people
    $distribution = [];
    for ($i = 0; $i < $numPeople; $i++) {
        $distribution[] = [];
    }
    
    $cardIndex = 0;
    while ($cardIndex < 52) {
        for ($i = 0; $i < $numPeople; $i++) {
            if ($cardIndex < 52) {
                $distribution[$i][] = $deck[$cardIndex];
                $cardIndex++;
            }
        }
    }
    
    // Convert the result into the requested format (comma separated)
    $result = [];
    foreach ($distribution as $personCards) {
        $result[] = implode(',', $personCards); // Join cards for each person
    }
    
    return implode(";", $result); // Join results with semicolon
}

// Read the number of people from the input
$numPeople = isset($_GET['numPeople']) ? intval($_GET['numPeople']) : 0;

// Call the distributeCards function
$response = distributeCards($numPeople);

// Output the result
echo json_encode(["result" => $response]);

?>