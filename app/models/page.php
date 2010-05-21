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
			$sql = " select area.id as id, area.code, area_language.name as name from area left join (select * from area_language where area_language.language_id=$view_iso and isnull(area_language.deleted)) as area_language on area.id=area_language.area_id ";
			$condition = " where isnull(area.deleted) ";
			$sql .= $condition;
		} else {
			$sql = " select area.id as id, area.code, area_language.name as name from area left join (select * from area_language where area_language.language_id=$view_iso and isnull(area_language.deleted)) as area_language on area.id=area_language.area_id ";
			$condition = " where area.code like '%$code%' ";
			$condition .= " and isnull(area.deleted) ";
			$sql .= $condition;
		}

		return $sql;
	}

	/**
	 * 国一覧sql
	 */
	function getSqlListCountry($view_iso = DEFAULT_ISO_ID, $code = null) {
		if(!$code) {
			$sql = " select country.id as id, country.iso_code_n, country.iso_code_a2, country.iso_code_a3, CountryLanguage.name_long as name from country as Country left join (select * from country_language where country_language.language_id=$view_iso and isnull(country_language.deleted)) as CountryLanguage on country.id=CountryLanguage.country_id ";
			$condition = " where isnull(country.deleted) ";
			$sql .= $condition;
		} else {
			$sql = " select country.id as id, country.iso_code_n, country.iso_code_a2, country.iso_code_a3, CountryLanguage.name_long as name from country as Country left join (select * from country_language where country_language.language_id=$view_iso and isnull(country_language.deleted)) as CountryLanguage on country.id=CountryLanguage.country_id ";
			$condition = " where country.iso_code_a2 like '%$code%'";
			$condition .= " and isnull(country.deleted) ";
			$sql .= $condition;
		}

		return $sql;
	}

	/**
	 * 都市一覧sql
	 */
	function getSqlListCity($view_iso = DEFAULT_ISO_ID, $country_id = null, $code = null) {
		$sql = " select City.id as id, City.country_id, City.code, CityLanguage.name, CountryLanguage.name_long from city as City left join (select * from city_language where city_language.language_id=$view_iso and isnull(city_language.deleted)) as CityLanguage on city.id=CityLanguage.city_id left join (select * from country_language where language_id=$view_iso and isnull(country_language.deleted)) as CountryLanguage on CountryLanguage.country_id=City.country_id ";
		$condition = " where City.code like '%$code%'";

		if($country_id) {
			$condition .= (" and City.country_id = " . $country_id);
		}
		if($code) {
			$condition .= (" and City.code like '%$code%' ");
		}

		$condition .= " and isnull(City.deleted) ";

		$sql .= $condition;

		return $sql;
	}

	/**
	 * content_block一覧sql
	 */
	function getSqlListContentBlock($view_iso = DEFAULT_ISO_ID, $language_id = null, $carrier_type_id = null, $alias = null) {
		$sql = " select ContentBlock.id as id, ContentBlock.language_id, LanguageLanguage.name, ContentBlock.carrier_type_id, CarrierType.name, ContentBlock.name, ContentBlock.alias from content_block as ContentBlock left join (select * from language_language where language_language.iso_language_id=$view_iso and isnull(language_language.deleted)) as LanguageLanguage on ContentBlock.language_id=LanguageLanguage.language_id left join (select * from carrier_type where isnull(carrier_type.deleted)) as CarrierType on ContentBlock.carrier_type_id=CarrierType.id ";
		$condition = " where isnull(ContentBlock.deleted) ";

		if($language_id) {
			$condition .= (" and ContentBlock.language_id = " . $language_id);
		}
		if($carrier_type_id) {
			$condition .= (" and ContentBlock.carrier_type_id = " . $carrier_type_id);
		}
		if($alias) {
			$condition .= (" and ContentBlock.alias like '%$alias%' ");
		}

		$sql .= $condition;

		return $sql;
	}

	/**
	 * content_layout一覧sql
	 */
	function getSqlListContentLayout($view_iso = DEFAULT_ISO_ID, $language_id = null, $carrier_type_id = null, $alias = null) {
		$sql = " select ContentLayout.id as id, ContentLayout.language_id, LanguageLanguage.name, ContentLayout.carrier_type_id, CarrierType.name, ContentLayout.name, ContentLayout.alias from content_layout as ContentLayout left join (select * from language_language where language_language.iso_language_id=$view_iso and isnull(language_language.deleted)) as LanguageLanguage on ContentLayout.language_id=LanguageLanguage.language_id left join (select * from carrier_type where isnull(carrier_type.deleted)) as CarrierType on ContentLayout.carrier_type_id=CarrierType.id ";
		$condition = " where isnull(ContentLayout.deleted) ";

		if($language_id) {
			$condition .= (" and ContentLayout.language_id = " . $language_id);
		}
		if($carrier_type_id) {
			$condition .= (" and ContentLayout.carrier_type_id = " . $carrier_type_id);
		}
		if($alias) {
			$condition .= (" and ContentLayout.alias like '%$alias%' ");
		}

		$sql .= $condition;

		return $sql;
	}

	/**
	 * content_page一覧sql
	 */
	function getSqlListContentPage($view_iso = DEFAULT_ISO_ID, $language_id = null, $carrier_type_id = null, $alias = null) {
		$sql = " select ContentPage.id as id, ContentPage.language_id, LanguageLanguage.name, ContentPage.carrier_type_id, ContentPage.content_layout_id, ContentLayout.name, ContentLayout.alias, CarrierType.name, ContentPage.name, ContentPage.alias from content_page as ContentPage left join (select * from language_language where language_language.iso_language_id=$view_iso and isnull(language_language.deleted)) as LanguageLanguage on ContentPage.language_id=LanguageLanguage.language_id left join (select * from carrier_type where isnull(carrier_type.deleted)) as CarrierType on ContentPage.carrier_type_id=CarrierType.id left join content_layout as ContentLayout on ContentPage.content_layout_id=ContentLayout.id ";
		$condition = " where isnull(ContentPage.deleted) ";

		if($language_id) {
			$condition .= (" and ContentPage.language_id = " . $language_id);
		}
		if($carrier_type_id) {
			$condition .= (" and ContentPage.carrier_type_id = " . $carrier_type_id);
		}
		if($alias) {
			$condition .= (" and ContentPage.alias like '%$alias%' ");
		}

		$sql .= $condition;

		return $sql;
	}

	/**
	 * image一覧sql
	 */
	function getSqlListContentImage($view_iso = DEFAULT_ISO_ID, $language_id = -1, $carrier_type_id = -1, $alias = null) {
		$sql = " select ContentImage.id as id, ContentImage.language_id as language_id, Language.iso_code, LanguageLanguage.name, ContentImage.carrier_type_id as carrier_type_id, CarrierType.name, ContentImage.alias, ContentImage.type, ContentImage.created, ContentImage.updated, ContentImage.deleted from content_image as ContentImage left join (select * from language_language where language_language.iso_language_id=$view_iso and isnull(language_language.deleted)) as LanguageLanguage on ContentImage.language_id=LanguageLanguage.language_id left join (select * from carrier_type where isnull(carrier_type.deleted)) as CarrierType on ContentImage.carrier_type_id=CarrierType.id left join (select * from language where isnull(language.deleted)) as Language on ContentImage.language_id=Language.id ";
		$condition = " where isnull(ContentImage.deleted) ";
		if($language_id != -1) {
			$condition .= (" and ContentImage.language_id = " . $language_id);
		}
		if($carrier_type_id != -1) {
			$condition .= (" and ContentImage.carrier_type_id = " . $carrier_type_id);
		}
		if($alias) {
			$condition .= (" and ContentImage.alias like '%$alias%' ");
		}

		$sql .= $condition;

		return $sql;
	}

	/**
	 * css一覧sql
	 */
	function getSqlListContentCss($view_iso = DEFAULT_ISO_ID, $language_id = -1, $carrier_type_id = -1, $alias = null) {
		$sql = " select ContentCss.id as id, ContentCss.language_id as language_id, Language.iso_code, LanguageLanguage.name, ContentCss.carrier_type_id as carrier_type_id, CarrierType.name, ContentCss.alias, ContentCss.created, ContentCss.updated, ContentCss.deleted from content_css as ContentCss left join (select * from language_language where language_language.iso_language_id=$view_iso and isnull(language_language.deleted)) as LanguageLanguage on ContentCss.language_id=LanguageLanguage.language_id left join (select * from carrier_type where isnull(carrier_type.deleted)) as CarrierType on ContentCss.carrier_type_id=CarrierType.id left join (select * from language where isnull(language.deleted)) as Language on ContentCss.language_id=Language.id ";
		$condition = " where isnull(ContentCss.deleted) ";
		if($language_id != -1) {
			$condition .= (" and ContentCss.language_id = " . $language_id);
		}
		if($carrier_type_id != -1) {
			$condition .= (" and ContentCss.carrier_type_id = " . $carrier_type_id);
		}
		if($alias) {
			$condition .= (" and ContentCss.alias like '%$alias%' ");
		}

		$sql .= $condition;

		return $sql;
	}

	function getSqlListDiscount() {
		$sql = " select ContentCss.id as id, ContentCss.language_id as language_id, Language.iso_code, LanguageLanguage.name, ContentCss.carrier_type_id as carrier_type_id, CarrierType.name, ContentCss.alias, ContentCss.created, ContentCss.updated, ContentCss.deleted from content_css as ContentCss left join (select * from language_language where language_language.iso_language_id=$view_iso and isnull(language_language.deleted)) as LanguageLanguage on ContentCss.language_id=LanguageLanguage.language_id left join (select * from carrier_type where isnull(carrier_type.deleted)) as CarrierType on ContentCss.carrier_type_id=CarrierType.id left join (select * from language where isnull(language.deleted)) as Language on ContentCss.language_id=Language.id ";
		$condition = " where isnull(ContentCss.deleted) ";
		$sql .= $condition;

		return $sql;
	}
}
?>