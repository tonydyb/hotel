<?php
class ConstructHelper extends AppHelper {

	function toArray($date = null, $isNullOK = false) {
		$keys = array('year','month','day','hour','min','sec');

		if (empty($date) && !$isNullOK) {
			$date = date("Y-m-d H:i:s");
		} else if(empty($date) && $isNullOK) {
			return array_combine($keys, array('','','','','',''));
		}

		$values = sscanf($date, '%d-%d-%d %d:%d:%d');
		return array_combine($keys, $values);
	}
}
?>
