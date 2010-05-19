<?php
	echo '<option value="0" selected></option>';
	foreach($countrys as $country) {
		echo '<option value='.$country['cl']['country_id'].'>'.$country['cl']['name_long'].'</option>';
	}
?>
