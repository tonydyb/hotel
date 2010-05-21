<?php
class SelectGetterComponent extends Object {

	var $components = array('Session');

	/**
	 * すべて言語リストを取得します。
	 *
	 */
	function getLanguage() {
		$userInstance = ClassRegistry::init('Language');
		$sql = "select language.id as id, language_language.name as name from language left join (select * from language_language where iso_language_id=" . $this->getIsoId() . "  and isnull(language_language.deleted)) as language_language on  language.id = language_language.language_id ";
		$sql .= "  where isnull(language.deleted) ";
		$sql .= " order by language_language.name ";
		return $userInstance->query($sql);
    }

    /**
	 * 最小言語リストを取得します。
	 *
	 */
	function getLanguageMin() {
		$userInstance = ClassRegistry::init('Language');
		$sql = "select language.id as id, language_language.name as name from language left join (select * from language_language where iso_language_id=" . $this->getIsoId() . "  and isnull(language_language.deleted)) as language_language on  language.id = language_language.language_id ";
		$condition = " where (language.id=" . DEFAULT_ISO_ID . " or language.id=" . JA_ISO_ID . " or language.id=" . ZH_ISO_ID . " or language.id=" . ZH_TW_ISO_ID . ") and isnull(language.deleted) ";
		$order = " order by language_language.name ";
		$sql .= $condition;
		$sql .= $order;
		return $userInstance->query($sql);
	}

	/**
	 * 国リストを取得します。
	 *
	 */
	function getCountry() {
		$userInstance = ClassRegistry::init('Country');
		return $userInstance->query("select country.id as id, country.iso_code_a2 as iso_code_a2, CountryLanguage.name_long as name from country as Country left join (select * from country_language where language_id=" . $this->getIsoId() . " and isnull(country_language.deleted)) as CountryLanguage on country.id = CountryLanguage.country_id where isnull(country.deleted) order by CountryLanguage.name_long");
    }

	/**
	 * 都市リストを取得します。
	 *
	 */
	function getCity($countryId = null) {
		if(!$countryId) {
			return false;
		}
		$userInstance = ClassRegistry::init('City');
		return $userInstance->query("select city.id as id, city.code as code, CityLanguage.name as name from city as City join (select * from city_language where language_id=" . $this->getIsoId() . " and isnull(city_language.deleted)) as CityLanguage on City.id = CityLanguage.city_id where City.country_id=$countryId and isnull(City.deleted) order by CityLanguage.name");
    }

	/**
	 * キャリアリストを取得します。
	 *
	 */
	function getCarrierType() {
		$userInstance = ClassRegistry::init('CarrierType');
		return $userInstance->query("select id, name from carrier_type as CarrierType where isnull(CarrierType.deleted)");
	}

	/**
	 * content layoutリストを取得します。
	 *
	 */
	function getContentLayout() {
		$userInstance = ClassRegistry::init('ContentLayout');
		return $userInstance->query("select id, name from content_layout as ContentLayout where isnull(ContentLayout.deleted)");
	}

	/**
	 * discount itemリストを取得する
	 */
	function getDiscountItem() {
		$userInstance = ClassRegistry::init('DiscountItem');
		return $userInstance->query("select id, code from discount_item as DiscountItem where isnull(DiscountItem.deleted)");
		//return $userInstance->find('list', array('fields' => array('code'), 'conditions' => array('DiscountItem.deleted' => null)));
	}

	/**
	 * discount typeリストを取得する
	 */
	function getDiscountType() {
		$userInstance = ClassRegistry::init('DiscountType');
		return $userInstance->query("select id, code from discount_type as DiscountType where isnull(DiscountType.deleted)");
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