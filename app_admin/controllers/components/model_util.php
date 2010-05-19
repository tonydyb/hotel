<?php
class ModelUtilComponent extends Object {

	function getSkeleton($model = null) {
		if(empty($model)) {
			return false;
		} else {
			$keys=array_keys($model->getColumnTypes());
			$cols=$model->getColumnTypes();
			foreach($keys as $key) {
				$cols[$key] = null;
			}
			return $cols;
		}
	}

	function stringDateToArray($date = null) {
		if (empty($date)) {
			$date = date("Y-m-d H:i:s");
		}

		$keys = array('year','month','day','hour','min','sec');
		$values = sscanf($date, '%d-%d-%d %d:%d:%d');
		return array_combine($keys, $values);
	}
}
?>