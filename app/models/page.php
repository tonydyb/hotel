<?php
class Page extends AppModel {

	var $name = 'Page';
	var $useTable = false;

	function paginate($conditions, $fields, $order, $limit, $page = 1, $recursive = null) {
		$offset = ($page * $limit - $limit) > 0 ? ($page * $limit - $limit) : 0;

		$sql = $conditions;
		$sql .= " order by " . $order;
		$sql .= " limit " . $limit;
		$sql .= " offset " . $offset;

		return $this->query($sql);
	}

	function paginateCount($conditions = null, $recursive = 0) {
		$sql = $conditions;

		$this->recursive = $recursive;

		$results = $this->query($sql);

		return count($results);
	}

	/**
	 * エリア一覧sql
	 */
	function getSqlListArea($view_iso = DEFAULT_ISO_ID, $code = null) {
		if(!$code) {
			$sql = " select area.id as id, area.code, area_language.name as name from area left join (select * from area_language where area_language.language_id=$view_iso ) as area_language on area.id=area_language.area_id ";
		} else {
			$sql = " select area.id as id, area.code, area_language.name as name from area left join (select * from area_language where area_language.language_id=$view_iso ) as area_language on area.id=area_language.area_id ";
			$condition = " where area.code like '%$code%'";
			$sql .= $condition;
		}

		return $sql;
	}

	/**
	 * 国一覧sql
	 */
	function getSqlListCountry($view_iso = DEFAULT_ISO_ID, $code = null) {
		if(!$code) {
			$sql = " select country.id as id, country.iso_code_n, country.iso_code_a2, country.iso_code_a3, CountryLanguage.name_long as name from country as Country left join (select * from country_language where country_language.language_id=$view_iso) as CountryLanguage on country.id=CountryLanguage.country_id ";
		} else {
			$sql = " select country.id as id, country.iso_code_n, country.iso_code_a2, country.iso_code_a3, CountryLanguage.name_long as name from country as Country left join (select * from country_language where country_language.language_id=$view_iso) as CountryLanguage on country.id=CountryLanguage.country_id ";
			$condition = " where country.iso_code_a2 like '%$code%'";
			$sql .= $condition;
		}

		return $sql;
	}

	/**
	 * 都市一覧sql
	 */
	function getSqlListCity($view_iso = DEFAULT_ISO_ID, $code = null) {
		if(!$code) {
			$sql = " select City.id as id, City.country_id, City.code, CityLanguage.name, CountryLanguage.name_long from city as City left join (select * from city_language where city_language.language_id=$view_iso) as CityLanguage on city.id=CityLanguage.city_id left join (select * from country_language where language_id=$view_iso) as CountryLanguage on CountryLanguage.country_id=City.country_id ";
		} else {
			$sql = " select City.id as id, City.country_id, City.code, CityLanguage.name, CountryLanguage.name_long from city as City left join (select * from city_language where city_language.language_id=$view_iso) as CityLanguage on city.id=CityLanguage.city_id left join (select * from country_language where language_id=$view_iso) as CountryLanguage on CountryLanguage.country_id=City.country_id ";
			$condition = " where City.code like '%$code%'";
			$sql .= $condition;
		}

		return $sql;
	}

	/**
	 * content_block一覧sql
	 */
	function getSqlListContentBlock($view_iso = DEFAULT_ISO_ID, $code = null) {
		if(!$code) {
			$sql = " select ContentBlock.id as id, ContentBlock.language_id, LanguageLanguage.name, ContentBlock.carrier_type_id, CarrierType.name, ContentBlock.name, ContentBlock.alias from content_block as ContentBlock left join (select * from language_language where language_language.iso_language_id=$view_iso) as LanguageLanguage on ContentBlock.language_id=LanguageLanguage.language_id left join (select * from carrier_type) as CarrierType on ContentBlock.carrier_type_id=CarrierType.id ";
		} else {
			$sql = " select ContentBlock.id as id, ContentBlock.language_id, LanguageLanguage.name, ContentBlock.carrier_type_id, CarrierType.name, ContentBlock.name, ContentBlock.alias from content_block as ContentBlock left join (select * from language_language where language_language.iso_language_id=$view_iso) as LanguageLanguage on ContentBlock.language_id=LanguageLanguage.language_id left join (select * from carrier_type) as CarrierType on ContentBlock.carrier_type_id=CarrierType.id ";
			$condition = " where ContentBlock.alias like '%$code%'";
			$sql .= $condition;
		}

		return $sql;
	}

	/**
	 * content_layout一覧sql
	 */
	function getSqlListContentLayout($view_iso = DEFAULT_ISO_ID, $code = null) {
		if(!$code) {
			$sql = " select ContentLayout.id as id, ContentLayout.language_id, LanguageLanguage.name, ContentLayout.carrier_type_id, CarrierType.name, ContentLayout.name, ContentLayout.alias from content_layout as ContentLayout left join (select * from language_language where language_language.iso_language_id=$view_iso) as LanguageLanguage on ContentLayout.language_id=LanguageLanguage.language_id left join (select * from carrier_type) as CarrierType on ContentLayout.carrier_type_id=CarrierType.id ";
		} else {
			$sql = " select ContentLayout.id as id, ContentLayout.language_id, LanguageLanguage.name, ContentLayout.carrier_type_id, CarrierType.name, ContentLayout.name, ContentLayout.alias from content_layout as ContentLayout left join (select * from language_language where language_language.iso_language_id=$view_iso) as LanguageLanguage on ContentLayout.language_id=LanguageLanguage.language_id left join (select * from carrier_type) as CarrierType on ContentLayout.carrier_type_id=CarrierType.id ";
			$condition = " where ContentLayout.alias like '%$code%'";
			$sql .= $condition;
		}

		return $sql;
	}

	/**
	 * content_page一覧sql
	 */
	function getSqlListContentPage($view_iso = DEFAULT_ISO_ID, $code = null) {
		if(!$code) {
			$sql = " select ContentPage.id as id, ContentPage.language_id, LanguageLanguage.name, ContentPage.carrier_type_id, ContentPage.content_layout_id, ContentLayout.name, ContentLayout.alias, CarrierType.name, ContentPage.name, ContentPage.alias from content_page as ContentPage left join (select * from language_language where language_language.iso_language_id=$view_iso) as LanguageLanguage on ContentPage.language_id=LanguageLanguage.language_id left join carrier_type as CarrierType on ContentPage.carrier_type_id=CarrierType.id left join content_layout as ContentLayout on ContentPage.content_layout_id=ContentLayout.id ";
		} else {
			$sql = " select ContentPage.id as id, ContentPage.language_id, LanguageLanguage.name, ContentPage.carrier_type_id, ContentPage.content_layout_id, ContentLayout.name, ContentLayout.alias, CarrierType.name, ContentPage.name, ContentPage.alias from content_page as ContentPage left join (select * from language_language where language_language.iso_language_id=$view_iso) as LanguageLanguage on ContentPage.language_id=LanguageLanguage.language_id left join carrier_type as CarrierType on ContentPage.carrier_type_id=CarrierType.id left join content_layout as ContentLayout on ContentPage.content_layout_id=ContentLayout.id ";
			$condition = " where ContentPage.alias like '%$code%'";
			$sql .= $condition;
		}

		return $sql;
	}
}
?>