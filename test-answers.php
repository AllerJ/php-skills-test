<?php

$guests = array (  
	array (
		'guest_id' => 177,
		'guest_type' => 'crew',
		'first_name' => 'Marco',
		'middle_name' => NULL,
		'last_name' => 'Burns',
		'gender' => 'M',
		'guest_booking' => array (  
			array (
				'booking_number' => 20008683,
				'ship_code' => 'OST',
				'room_no' => 'A0073',
				'start_time' => 1438214400,
				'end_time' => 1483142400,
				'is_checked_in' => true,
			),
		),
		'guest_account' => array (  
			array (
				'account_id' => 20009503,
				'status_id' => 2,
				'account_limit' => 0,
				'allow_charges' => true,
			),
		),
	),
	array (
		'guest_id' => 10000113,
		'guest_type' => 'crew',
		'first_name' => 'Bob Jr ',
		'middle_name' => 'Charles',
		'last_name' => 'Hemingway',
		'gender' => 'M',
		'guest_booking' => array (  
			array (
				'booking_number' => 10000013,
				'room_no' => 'B0092',
				'is_checked_in' => true,
			),
		),
		'guest_account' => array (  
			array (
				'account_id' => 10000522,
				'account_limit' => 300,
				'allow_charges' => true,
			),
		),
	),
	array (
		'guest_id' => 10000114,
		'guest_type' => 'crew',
		'first_name' => 'Al ',
		'middle_name' => 'Bert',
		'last_name' => 'Santiago',
		'gender' => 'M',
		'guest_booking' => array (  
			array (
				'booking_number' => 10000014,
				'room_no' => 'A0018',
				'is_checked_in' => true,
			),
		),
		'guest_account' => array (  
			array (
				'account_id' => 10000013,
				'account_limit' => 300,
				'allow_charges' => false,
			),
		),
	),
	array (
		'guest_id' => 10000115,
		'guest_type' => 'crew',
		'first_name' => 'Red ',
		'middle_name' => 'Ruby',
		'last_name' => 'Flowers ',
		'gender' => 'F',
		'guest_booking' => array (  
			array (
				'booking_number' => 10000015,
				'room_no' => 'A0051',
				'is_checked_in' => true,
			),
		),
		'guest_account' => array (  
			array (
				'account_id' => 10000519,
				'account_limit' => 300,
				'allow_charges' => true,
			),
		),
	),
	array (
		'guest_id' => 10000116,
		'guest_type' => 'crew',
		'first_name' => 'Ismael ',
		'middle_name' => 'Jean-Vital',
		'last_name' => 'Jammes',
		'gender' => 'M',
		'guest_booking' => array (  
			array (
				'booking_number' => 10000016,
				'room_no' => 'A0023',
				'is_checked_in' => true,
			),
		),
		'guest_account' => array (  
			array (
				'account_id' => 10000015,
				'account_limit' => 300,
				'allow_charges' => true,
			),
		),
	),
);


// Quick function to convert the array key in snake_case to easier to read text.
// @param string $key
function easy_to_read( $key ) {
	return ucwords( str_replace( '_', ' ', $key ) );
}

// Response to question 1
// @param array $guests
// @param string $key
function question_one( $guests, $key ) {
		$record = "--------------------------- GUESTS SORT BY " . strtoupper(easy_to_read($key)) . "---------------------------\n\n\n";

		// Start looping over the array of guests
		foreach( $guests as $guest ) {

			// Add a header to each guest record that is returned.
			$record .= "------- Guest Booking Record -------\n";

			// Loop through the array in each guest record						
			foreach( $guest as $key => $value ) {
				
				// If one of the keys is guest_booking or guest_account loop through them to get sub array information		
				if( $key == 'guest_booking' || $key == 'guest_account' ) {
					
					// Add a heading for these two sub sections by taking the key name and sending it to the easy_to_read() function to get a nicely formatted heading
					$record .= "\n\t - " . easy_to_read( $key ) . " - \n";
					
					// Display the key/value pairs in the sub array of parent key
					foreach($value[0] as $key => $value) {
						$record .= "\t" . easy_to_read( $key ) . ': ' . easy_to_read( $value ) . "\n";
					}
				
				// Do the following for all other key/value pairs
				} else {
					$record .= easy_to_read( $key ) . ': ' . easy_to_read( $value ) . "\n";
				}
				
			}
			// Add some breaking spaces between records
			$record .= "\n\n";
			
		}
	return $record;
}

// Answer to Question 2
// @param string $key
function question_two($key = 'last_name') {

	GLOBAL $guests;
	$by_key=[];

	// Loop through guests and add them to a new array to be sent to the question_one() function for output	
	foreach($guests as $guest) {
	
		// use array_walk_recursive() to flatten the associative array making it easier to do a search on all key/values
		$arr=[];
		array_walk_recursive(
			  $guest, 
			  function($item, $key) use (&$arr) {
				   $arr[$key]=$item;
			   }
		);
	
		// Add just the guest_id to a new array
		$by_key[$arr['guest_id']] = $arr[$key] ;
		
	}
	
	// Sort the new guest_id array alphabetically
	asort($by_key);
	$final = [];
	
	// Loop through new array
	foreach($by_key as $build => $value) {
		
		// Extract the guest records that match the search criteria
		$final_hold = array_filter($guests, function ($item) use ($build) {
				if ($item['guest_id'] == $build) {
					return $item;
				}	
			});
			
		// move the associateive arrays up one level.
		array_shift(array_values($final_hold));
		$final[]  = array_shift(array_values($final_hold));
		
	}

	return question_one($final, $key);
	
}

// Make this a command line program. Grab STDIN
$stdin = fopen('php://stdin', 'r');
echo 'Key to sort on: ';

// Capture the input and trim the last character off which would be a return
$input = trim(fgets($stdin));

// Send the input to the question_two() function for search
echo question_two($input);


?>