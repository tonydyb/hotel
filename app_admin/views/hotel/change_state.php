<?php
	echo '<option value="0"></option>';
	foreach($citys as $city) {
		echo '<option value='.$city['cl']['city_id'].'>'.$city['cl']['name'].'</option>';
	}
?>
