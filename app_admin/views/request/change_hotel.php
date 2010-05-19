<?php
	echo '<option value="0" selected></option>';
	foreach($rooms as $room) {
		echo '<option value='.$room['hrl']['hotel_room_id'].'>'.$room['hrl']['name'].'</option>';
	}
?>
