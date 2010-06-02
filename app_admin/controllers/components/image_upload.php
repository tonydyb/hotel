<?php
class ImageUploadComponent extends Object {

	/**
	 * 画像のリサイズ・保存
	 *
	 * @param string $srcImagePath 絶対パス
	 * @param string $saveDirPath 絶対パスかwebroot/img/からのパス '/'と指定した場合webroot/img/となる
	 * @param string $newImageName 保存画像名
	 * @param int $newWidth
	 * @param int $newHeight
	 * @param boolean $aspectRatio 画像横縦比の維持フラグ true:維持する false:維持しない
	 * @param boolean $del ソース画像の削除フラグ
	 * @return string $newImageName 画像名
	 */
	function resize($srcImagePath, $saveDirPath, $newImageName, $reSize = false, $newWidth = 0, $newHeight = 0, $aspectRatio = false, $del = false) {
		$imageInfo = getimagesize($srcImagePath);
		$exts = array(1 => 'gif', 2 => 'jpeg', 3 => 'png');
		$srcWidth  = $imageInfo[0];
		$srcHeight = $imageInfo[1];
		$imageType = $exts[$imageInfo[2]];

		$saveDirPath = $this->_getPath($saveDirPath);

		if ($reSize) {
			if ($aspectRatio) {
				if ($srcWidth < $srcHeight) {
					// 縦に長い場合
					$newWidth = ($newHeight * $srcWidth) / $srcHeight;
				} else {
					// 横に長い場合
					$newHeight = ($newWidth * $srcHeight) / $srcWidth;
				}
			}
		} else {
			$newWidth = $srcWidth;
			$newHeight = $srcHeight;
		}

		$createFunc = 'imagecreatefrom'.$imageType;
		$saveFunc = 'image'.$imageType;

		// 画像のリサイズ
		$srcImage = $createFunc($srcImagePath);
		$newImage = imagecreatetruecolor($newWidth, $newHeight);
		imagecopyresampled($newImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $srcWidth, $srcHeight);
		if ($imageType == 'jpeg') {
			$regex1 = "/\.jpeg$/";
			$regex2 = "/\.jpg$/";
			if (!preg_match($regex1, $newImageName) && !preg_match($regex2, $newImageName)) {
				$newImageName .= ".jpg";
			}
			$saveFunc($newImage, $saveDirPath.$newImageName, 100);
		} else {
			$regex = "/\.".$imageType."$/";
			if (!preg_match($regex, $newImageName)) {
				$newImageName .= ".{$imageType}";
			}
			$saveFunc($newImage, $saveDirPath.$newImageName);
		}

		// ソース画像の削除
		if ($del) {
			$this->del($srcImagePath);
		}

		return $newImageName;
	}

	/**
	 * 画像ファイルの削除
	 * unlinkのラッパーメソッド
	 *
	 * @param string $imagePath 画像ファイルのパス 絶対パスかwebroot/img/からのパス
	 * @return boolean
	 */
	function del($imagePath) {
		$iamgePath = $this->_getPath($imagePath);
		if (file_exists($iamgePath)) {
			return unlink($iamgePath);
		} else {
			return false;
		}
	}

	/**
	 * パスの取得
	 *
	 * @param $path
	 * @return string $path
	 */
	function _getPath($path) {
		// フルパスの場合はそのまま返す
		if (strpos($path, ':'.DS) === false && strpos($path, ':/') === false) {
			if (empty($path) || $path == '/') {
				$path = IMAGES;
			} else {
				$path = preg_replace("/^\//", '', $path);
				$path = IMAGES.$path;
				if (!preg_match('/\.[a-zA-Z]+$/', $path)) {
					// ディレクトリパスの場合
					$path .= !preg_match('/\/$/', $path) ? '/' : '';
				}
			}
		}
		$path = str_replace(DS, '/', $path);

		return $path;
	}
}
?>