<?php
class NameGetterComponent extends Object {

	var $components = array('Session');

	/**
	 * 言語名前を取得します。
	 *
	 */
	function getLanguageName($languageId) {
    }

	/**
	 * 国名前を取得します。
	 *
	 */
	function getCountryName($countryId) {
		$userInstance = ClassRegistry::init('Country');
		$lg = $userInstance->query("select CountryLanguage.name_long as name from (select * from country_language where language_id=" . $this->getIsoId() . " and isnull(country_language.deleted)) as CountryLanguage where CountryLanguage.country_id=" . $countryId);
		return $lg[0]['CountryLanguage']['name'];
    }

	/**
	 * 都市名前を取得します。
	 *
	 */
	function getCityName($cityId) {
    }


	function getIsoId() {
		$sql = "select id from language where iso_code='" . $this->Session->read('view_iso') . "' and isnull(language.deleted)";
		$result = mysql_query($sql);
		if (!$result) {
			die('Invalid query: ' . mysql_error());
		} else {
			if (mysql_num_rows($result)) {
				$row = mysql_fetch_row($result);
				return $row[0];
			} else {
				return DEFAULT_ISO_ID;
			}
		}
	}
}
?>