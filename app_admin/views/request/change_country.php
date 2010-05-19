<?php
	echo '<option value="0"></option>';
	foreach($states as $state) {
		echo '<option value='.$state['sl']['state_id'].'>'.$state['sl']['name'].'</option>';
	}
?>
