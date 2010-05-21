<?php
config('voucher_const');
class VoucherController extends AppController {
	var $name = "Voucher";
	var $uses = array(
					'RequestHotel',
					'RequestHotelCustomerUser',
					'HotelAgent',
					'CountryLanguage',
					'HotelEmergencyContact',
	);
	var $needAuth = false;	// ログイン必須のフラグ
	var $components = array('Voucher', );
	var $layout = "no_layout";

	function index($customer_user_id, $password, $request_hotel_id) {


		$request_hotel;
		$request_hotel_customer_user;

		$this->Voucher->index('', VOUCHER_ISO_CODE, $customer_user_id, base64_decode($password), $request_hotel_id, $request_hotel, $request_hotel_customer_user);

		$this->set('request_hotel', $request_hotel);
		$this->set('request_hotel_customer_user', $request_hotel_customer_user);

		$this->render('/elements/voucher/html/voucher/');
	}
}
?>