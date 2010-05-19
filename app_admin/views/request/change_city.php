<?php
	echo '<option value="0" selected></option>';
	foreach($hotels as $hotel) {
		echo '<option value='.$hotel['hl']['hotel_id'].'>'.$hotel['hl']['name'].'</option>';
	}
?>
