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

function easy_to_read( $key ) {
	return ucwords( str_replace( '_', ' ', $key ) );
}

function question_one( $guests, $key ) {
		$record = "--------------------------- GUESTS SORT BY " . strtoupper(easy_to_read($key)) . "---------------------------\n\n\n";
		foreach( $guests as $guest ) {
		
			$record .= "------- Guest Booking Record -------\n";
						
			foreach( $guest as $key => $value ) {
				

				
				if( $key == 'guest_booking' || $key == 'guest_account' ) {
					
					$record .= "\n\t - " . easy_to_read( $key ) . " - \n";
					
					foreach($value[0] as $key => $value) {
						$record .= "\t" . easy_to_read( $key ) . ': ' . easy_to_read( $value ) . "\n";
					}
				
				} else {
					$record .= easy_to_read( $key ) . ': ' . easy_to_read( $value ) . "\n";
				}
				
			}
			
			$record .= "\n\n";
			
		}
	return $record;
}

function question_two($key = 'last_name') {
	GLOBAL $guests;
	$by_key=[];
	
	foreach($guests as $guest) {
	
		$arr=[];
		array_walk_recursive(
			  $guest, 
			  function($item, $key) use (&$arr) {
				   $arr[$key]=$item;
			   }
		);
	
		$by_key[$arr['guest_id']] = $arr[$key] ;
		
	}
	asort($by_key);
	$final = [];
	foreach($by_key as $build => $value) {
	
		$final_hold = array_filter($guests, function ($item) use ($build) {
				if ($item['guest_id'] == $build) {
					return $item;
				}	
			});
		array_shift(array_values($final_hold));
		$final[]  = array_shift(array_values($final_hold));
		
	}
	
	
	return question_one($final, $key);
	
}

$stdin = fopen('php://stdin', 'r');
echo 'Key to sort on: ';
$input = trim(fgets($stdin));

echo question_two($input);


?>