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

	/**
	 * フォルド作成
	 */
	function mkdirRec($pathStr = null, $mode = 0777) {
		$path_arr = explode('/', $pathStr);

		foreach ($path_arr as $value) {
			if(!empty($value)) {
				if(empty($path)) {
					$path = $value;
				} else {
					$path .= '/' . $value;
				}

				is_dir($path) or mkdir($path, $mode);
			}
		}

		if(is_dir($path)) {
			return true;
		}

		return false;
	}

}
?>