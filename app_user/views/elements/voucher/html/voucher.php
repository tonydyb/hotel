<html>
<head>
<title><?php echo __(格安トラベル); ?></title>
<style type=text/css>
html {
	padding-right: 0px; padding-left: 0px; padding-bottom: 0px; margin: 0px; padding-top: 0px; height: 100%
}
body {
	padding-right: 0px; padding-left: 0px; font-size: 11px; background: #fff; padding-bottom: 0px; margin: 0px; color: #000; line-height: 16px; padding-top: 0px; font-family: verdana, arial, "lucida grande", "lucida sans unicode", lucida
}
#body {
	margin: auto
}
.clearfix {
	clear: both; display: block; font-size: 0px; line-height: 0; height: 0px
}
.bold {
	font-weight: bold
}
td.firstline {
	padding-top: 15px important
}
td.line {
	padding-right: 0px; padding-left: 0px; font-size: 1px; padding-bottom: 0px; margin: 0px 0px 5px; width: 100%; line-height: 1px; padding-top: 0px; border-bottom: #dddddd 1px solid; height: 1px
}
div.line {
	padding-right: 0px; padding-left: 0px; font-size: 1px; padding-bottom: 0px; margin: 0px 0px 5px; width: 100%; line-height: 1px; padding-top: 0px; border-bottom: #dddddd 1px solid; height: 1px
}
td.line br {
	font-size: 1px; line-height: 1px; height: 1px
}
.standardtableheader {
	border-right: white 1px solid; padding-right: 3px; padding-left: 3px; padding-bottom: 3px; vertical-align: top; color: #ffffff; line-height: 16px; padding-top: 3px; height: 18px; background-color: #50646d; text-align: left
}
#iteneraryform td {
	font-size: 12px
}
#confirmationform td {
	font-size: 12px
}
#voucherform td {
	font-size: 12px
}
#voucherform p {
	font-size: 12px
}
#voucherform span {
	font-size: 12px
}
#voucherform .reservationinfoaddress {
	font-size: 12px
}
#voucher {
	float: left; width: 100%
}
#voucherform .reservationinfoaddress {
	float: left; width: 100%
}
#voucherform .emergencycontact {
	float: left; width: 100%
}
#documentspage {
	float: left; width: 100%
}
.documentoverviewbooking {
	float: left; width: 100%
}
.document {
	float: left; width: 100%
}
#voucherform div.headline {
	font-weight: bold; font-size: 19px; color: black; font-family: verdana
}
#confirmationform .headerblock span.headertitle {
	font-weight: bold; font-size: 19px; color: black; font-family: verdana
}
#iteneraryform .headerblock span.headertitle {
	font-weight: bold; font-size: 19px; color: black; font-family: verdana
}
#voucherform div.headline {
	float: left; margin-bottom: 20px; width: 100%
}
#iteneraryform {
	height: auto
}
#confirmationform .headerblock {
	clear: left; float: left; margin: 0px 0px 42px; width: 100%
}
#iteneraryform .headerblock {
	clear: left; float: left; margin: 0px 0px 42px; width: 100%
}
#confirmationform .headerblock {
	padding-left: 0px; margin: 0px 0px 25px
}
#iteneraryform .headerblock span {
	float: right
}
#confirmationform .headerblock span.headertitle {
	padding-left: 5px; font-size: 17px; float: left; width: 400px; height: 20px
}
#iteneraryform .headerblock span.headertitle {
	padding-left: 5px; font-size: 17px; float: left; width: 400px; height: 20px
}
#confirmationform .headerblock span.locationanddate {
	display: block; padding-left: 5px; font-size: 12px; float: left; margin: 10px 0px; width: 90%; height: 20px
}
#iteneraryform .headerblock span.locationanddate {
	display: none; font-size: 12px; margin-right: 10px
}
#confirmationform .legalunitaddress {
	padding-right: 50px
}
#confirmationform .headerdetail {
	float: left; margin-bottom: 50px
}
#iteneraryform .headerdetail {
	float: left; margin-bottom: 50px
}
#confirmationform .headerdetail span.title {
	display: block; width: 120px important
}
#iteneraryform .headerdetail span.title {
	display: block; width: 120px important
}
#confirmationform .headerdetail span {
	padding-left: 5px; font-size: 14px; float: left
}
#iteneraryform .headerdetail span {
	padding-left: 5px; font-size: 14px; float: left
}
#confirmationform .agentaddress {
	padding-left: 5px; float: left; margin: 0px 0px 20px
}
#confirmationform .headerdetail .value {
	display: block
}
#iteneraryform .headerdetail .value {
	display: block
}
#confirmationform .headerdetail .bookingno {
	margin-bottom: 4px
}
#iteneraryform .headerdetail .bookingno {
	margin-bottom: 4px
}
#iteneraryform table.itenerarytable {
	border-top-width: 0px; padding-right: 0px; padding-left: 0px; border-left-width: 0px; float: left; border-bottom-width: 0px; padding-bottom: 0px; margin: 0px; width: 99%; padding-top: 0px; border-collapse: collapse; border-right-width: 0px; border-spacing: 0
}
#iteneraryform table.emergencytable {
	border-top-width: 0px; padding-right: 0px; padding-left: 0px; border-left-width: 0px; float: left; border-bottom-width: 0px; padding-bottom: 0px; margin: 0px; width: 99%; padding-top: 0px; border-collapse: collapse; border-right-width: 0px; border-spacing: 0
}
#iteneraryform table.itenerarytable th {
	border-top-width: 0px; padding-right: 0px; padding-left: 5px; border-left-width: 0px; font-size: 12px; border-bottom-width: 0px; padding-bottom: 3px; line-height: 20px; padding-top: 3px; height: 48px; border-right-width: 0px
}
#iteneraryform table.itenerarytable th.columnthree {
	width: 15%
}
#iteneraryform table.itenerarytable th.columnfour {
	width: 15%
}
#iteneraryform table.itenerarytable td {
	border-top-width: 0px; padding-right: 0px; padding-left: 5px; border-left-width: 0px; border-bottom-width: 0px; padding-bottom: 3px; vertical-align: top; line-height: 14px; padding-top: 3px; border-right-width: 0px
}
#iteneraryform table.emergencytable td {
	border-top-width: 0px; padding-right: 0px; padding-left: 5px; border-left-width: 0px; border-bottom-width: 0px; padding-bottom: 3px; vertical-align: top; line-height: 14px; padding-top: 3px; border-right-width: 0px
}
#iteneraryform table.emergencytable td {
	padding-left: 0px
}
#iteneraryform table.itenerarytable td.titleline {
	padding-top: 20px
}
#confirmationform .headerdetail .bookingno {
	float: left; width: 100%
}
#confirmationform .headerdetail .guestname {
	float: left; width: 100%
}
#confirmationform .headerdetail .agentinfo {
	float: left; width: 100%
}
#iteneraryform .headerdetail .bookingno {
	float: left; width: 100%
}
#iteneraryform .headerdetail .guestname {
	float: left; width: 100%
}
#confirmationform .headerdetail .bookingno span.title {
	width: 170px important
}
#confirmationform .headerdetail .guestname span.title {
	width: 170px important
}
#confirmationform .headerdetail .agentinfo span.title {
	width: 170px important
}
#iteneraryform .headerdetail .bookingno span.title {
	width: 170px important
}
#iteneraryform .headerdetail .guestname span.title {
	width: 170px important
}
#iteneraryform table .line {
	padding-right: 0px; padding-left: 0px; padding-bottom: 0px; margin: 10px 0px 0px; width: 100%; padding-top: 0px
}
#confirmationform .headerimage {
	float: left; margin: 15px 0px 70px; width: 100%
}
#iteneraryform .headerimage {
	float: left; margin: 15px 0px 70px; width: 100%
}
#voucherform .headerimage {
	float: left; margin: 15px 0px 70px; width: 100%
}
#iteneraryform .printonly {
	display: none
}
#confirmationform .agentaddress span {
	font-size: 12px
}
#confirmationform .agentaddress span.addressline {
	display: block
}
#confirmationform .legalunitaddress {
	float: right
}
#confirmationform .legalunitaddress span.addressline {
	display: block; font-family: georgia, verdana, arial
}
#confirmationform table.confirmationtable {
	padding-right: 0px; padding-left: 0px; padding-bottom: 0px; margin: 0px; width: 99%; padding-top: 0px; border-collapse: collapse; border-spacing: 0
}
#confirmationform table.confirmationtable th {
	border-top-width: 0px; padding-right: 0px; padding-left: 5px; border-left-width: 0px; font-size: 12px; border-bottom-width: 0px; padding-bottom: 3px; line-height: 20px; padding-top: 3px; height: 48px; border-right-width: 0px
}
#confirmationform table.confirmationtable td {
	border-top-width: 0px; padding-right: 0px; padding-left: 5px; border-left-width: 0px; font-size: 11px; border-bottom-width: 0px; padding-bottom: 3px; vertical-align: top; line-height: 18px; padding-top: 3px; border-right-width: 0px
}
#confirmationform table.confirmationtable td table {
	padding-right: 0px; padding-left: 0px; padding-bottom: 0px; margin: 0px; width: 100%; padding-top: 0px; border-collapse: collapse; border-spacing: 0
}
#confirmationform table.confirmationtable td table td {
	padding-right: 0px; padding-left: 0px; padding-bottom: 0px; padding-top: 0px
}
#confirmationform table.confirmationtable .columnseven {
	text-align: right
}
#confirmationform table.confirmationtable .columneight {
	padding-right: 15px; text-align: right
}
#confirmationform table.confirmationtable table .columneight {
	padding-right: 0px
}
#confirmationform table.confirmationtable th.columnone {
	width: 100px
}
#confirmationform table.confirmationtable th.columntwo {
	width: 150px
}
#confirmationform table.confirmationtable td.columntwo {
	width: 150px
}
#confirmationform table.confirmationtable th.columnthree {
	width: 50px
}
#confirmationform table.confirmationtable td.columnthree {
	width: 50px
}
#confirmationform table.confirmationtable th.columnfour {
	width: 120px
}
#confirmationform table.confirmationtable td.columnfour {
	width: 120px
}
#confirmationform table.confirmationtable th.columnfive {
	width: 50px
}
#confirmationform table.confirmationtable td.columnfive {
	width: 50px
}
#confirmationform table.confirmationtable th.columnsix {
	width: 130px
}
#confirmationform table.confirmationtable td.columnsix {
	width: 130px
}
#confirmationform table.confirmationtable th.columnseven {
	width: 130px
}
#confirmationform table.confirmationtable td.columnseven {
	width: 130px
}
#confirmationform table.confirmationtable td.columnseven {
	text-align: right
}
#confirmationform table.confirmationtable th.columneight {
	width: 130px
}
#confirmationform table.confirmationtable td.columneight {
	width: 130px
}
#confirmationform table.confirmationtable td.columneight {
	text-align: right
}
#confirmationform table.confirmationtable tr.cxpolicyrow table td.columneight {
	padding-right: 10px
}

#confirmationform table.confirmationtable tr.cxpolicyrow td {
	border-right: #ccc 1px dotted; border-top: #ccc 1px dotted; border-left: #ccc 0px dotted; border-bottom: #ccc 1px dotted
}
#confirmationform table.confirmationtable tr.cxpolicyrow td.cxlabel {
	font-size: 9px important; border-left: #ccc 1px dotted; border-right-width: 0px
}
#confirmationform table.confirmationtable tr.cxpolicyrow table td {
	border-top-width: 0px; border-left-width: 0px; font-size: 9px important; border-bottom-width: 0px; border-right-width: 0px
}
#voucherform .toplabel {
	padding-right: 0px; padding-left: 0px; font-weight: bold; padding-bottom: 10px; color: black; line-height: 20px; padding-top: 0px
}
#voucherform table.voucherdetailstable {
	padding-right: 0px; padding-left: 0px; float: left; padding-bottom: 0px; margin: 0px; width: 100%; padding-top: 0px; border-collapse: collapse; border-spacing: 0
}
#voucherform table.emergencytable {
	padding-right: 0px; padding-left: 0px; float: left; padding-bottom: 0px; margin: 0px; width: 100%; padding-top: 0px; border-collapse: collapse; border-spacing: 0
}
#voucherform table.voucherdetailstable td {
	padding-right: 0px; padding-left: 0px; padding-bottom: 1px; vertical-align: top; padding-top: 1px
}
#voucherform table.voucherdetailstable td.firstrow {
	width: 25%
}
#voucherform table.voucherdetailstable td.secondrow {
	width: 75%
}
#voucherform table.voucherdetailstable td.empty {
	height: 10px
}
#voucherform .reservationinfoaddress {
	padding-right: 0px; border-top: #ccc 1px solid; margin-top: 10px; padding-left: 0px; padding-bottom: 10px; padding-top: 10px
}
#voucherform .emergencycontact {
	padding-right: 0px; border-top: #ccc 1px solid; padding-left: 0px; margin-bottom: 20px; padding-bottom: 20px; padding-top: 20px; border-bottom: #ccc 1px solid
}
#voucherform .emergencycontact p.toplabel {
	padding-bottom: 15px; width: 100%
}
#voucherform #locationmap p.toplabel {
	padding-bottom: 15px; width: 100%
}
#voucherform #locationmap {

}
#voucherform div#pagebreakbeforelocationmap {
	page-break-after: always
}
#voucherform div#spacebeforelocationmap {

}
#voucherform #boxoffice {
	padding-right: 0px; padding-left: 0px; float: left; padding-bottom: 10px; margin: 10px 0px; padding-top: 10px; border-bottom: #ccc 1px solid
}
#voucherform #hoteldelivery {
	padding-right: 0px; padding-left: 0px; float: left; padding-bottom: 10px; margin: 10px 0px; padding-top: 10px; border-bottom: #ccc 1px solid
}
#voucherform #voucherexchange {
	padding-right: 0px; padding-left: 0px; float: left; padding-bottom: 10px; margin: 10px 0px; padding-top: 10px; border-bottom: #ccc 1px solid
}
#voucherform #meetingpoint {
	padding-right: 0px; padding-left: 0px; float: left; padding-bottom: 10px; margin: 10px 0px; padding-top: 10px; border-bottom: #ccc 1px solid
}
#voucherform #hotelpickuppoints {
	padding-right: 0px; padding-left: 0px; float: left; padding-bottom: 10px; margin: 10px 0px; padding-top: 10px; border-bottom: #ccc 1px solid
}
#voucherform #multiplepickuppoints {
	padding-right: 0px; padding-left: 0px; float: left; padding-bottom: 10px; margin: 10px 0px; padding-top: 10px; border-bottom: #ccc 1px solid
}
#voucherform #transfer {
	padding-right: 0px; padding-left: 0px; float: left; padding-bottom: 10px; margin: 10px 0px; padding-top: 10px
}
#voucherform table.emergencytable td {
	padding-right: 0px; padding-left: 0px; padding-bottom: 3px; vertical-align: top; line-height: 22px; padding-top: 3px
}
#voucherform table.emergencytable td.firstrow {
	width: 25%
}
#voucherform table.emergencytable td.secondrow {
	width: 40%
}
#voucherform table.emergencytable td.thirdrow {
	width: 35%
}
</style>
</head>
<body id=body>
<div id=main>
<div id=content style="width: 100%; height: 100%">
<div>
<div class=document>
<div id=voucherform>
<div class=headerimage>
	<img alt="サイバートラベルロゴ" src="http://kakuyasutravel.com/images/cyber_logo.gif">
</div>
<div id=voucher>
<div class=headline>voucher</div>
<table class=voucherdetailstable>
	<tbody>
		<tr>
			<td class=firstrow>booking number:</td>
			<td class=secondrow><?php echo $request_hotel['hotel_agent_ref']; ?></td></tr>
			<td class=empty colspan=2></td>
		</tr>
		<tr>
			<td>guests:</td>
			<td><?php echo $request_hotel['adult_count'] + $request_hotel['child_count']; ?> adult(s)</td>
		</tr>
		<tr>
			<td>guest name(s):</td>
			<td>
				<?php
					foreach ($request_hotel_customer_user as $user) {
						if ($user['gender_id'] == GENDER_ID_MALE) {
							echo 'Mr.';
						} else {
							echo 'Ms.';
						}
						echo $user['first_name'].' '.$user['last_name'].'<br />';
					}
				?>
					<br />
			</td>
		</tr>
		<tr>
			<td class=empty colspan=2></td>
		</tr>
		<tr>
			<td>hotel/service:</td>
			<td>
				<span class=bold>
					hotel <?php echo $request_hotel['hotel_name'].', '.$request_hotel['city'].'('.$request_hotel['country'].')'; ?>
				</span>
				<br />
				<?php
					$street ='';
					$street .= !empty($request_hotel['hotel_addr_3']) ? (empty($street) ? ', '.$request_hotel['hotel_addr_3'] : $request_hotel['hotel_addr_3']) : '';
					$street .= !empty($request_hotel['hotel_addr_2']) ? (empty($street) ? ', '.$request_hotel['hotel_addr_2'] : $request_hotel['hotel_addr_2']) : '';
					$street .= !empty($request_hotel['hotel_addr_1']) ? (empty($street) ? ', '.$request_hotel['hotel_addr_1'] : $request_hotel['hotel_addr_1']) : '';
					echo $street.'<br />'.$request_hotel['hotel_postcode'].' '.$request_hotel['city'].'<br />'.'t + '.$request_hotel['hotel_tel'];
				?>
			</td>
		</tr>
		<tr>
			<td class=empty colspan=2></td></tr>
		<tr>
			<td></td>
			<td></td></tr>
		<tr>
			<td>service units:</td>
			<td>1 <?php echo $request_hotel['hotel_room_name'] ?></td></tr>
		<tr>
			<td>date:</td>
			<td><?php echo $request_hotel['checkin']['date'].' - '.$request_hotel['checkout']['date']; ?></td></tr>
		<tr>
			<td>meal plan:</td>
			<td><?php echo !empty($request_hotel['breakfast_name']) ? $request_hotel['breakfast_name'] : 'Not Included'; ?></td>
		</tr>
	</tbody>
</table>
<table class=voucherdetailstable>
	<tbody>
		<tr>
			<td class=firstrow></td>
			<td class=secondrow></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
	</tbody>
</table>
<div class=reservationinfoaddress>
	<?php
		$present = '';
		$present .= $request_hotel['hotel_agent']['name'].' ';
		$present .= !empty($request_hotel['hotel_agent']['addr_3']) ? (!empty($present) ? ', '.$request_hotel['hotel_agent']['addr_3'] : $request_hotel['hotel_agent']['addr_3']) : '';
		$present .= !empty($request_hotel['hotel_agent']['addr_2']) ? (!empty($present) ? ', '.$request_hotel['hotel_agent']['addr_2'] : $request_hotel['hotel_agent']['addr_2']) : '';
		$present .= !empty($request_hotel['hotel_agent']['addr_1']) ? (!empty($present) ? ', '.$request_hotel['hotel_agent']['addr_1'] : $request_hotel['hotel_agent']['addr_1']) : '';
		$present .= !empty($request_hotel['hotel_agent']['postcode']) ? (!empty($present) ? ', '.$request_hotel['hotel_agent']['postcode'] : $request_hotel['hotel_agent']['postcode']) : '';
		$present .= !empty($request_hotel['hotel_agent']['country']) ? (!empty($present) ? ', '.$request_hotel['hotel_agent']['country'] : $request_hotel['hotel_agent']['country']) : '';
		echo 'reservation and payment by: '.$present;
	?>
</div>
<?php if (!is_null($request_hotel['emergency_contact'])) { ?>
	<div class=emergencycontact>
		<p class=toplabel>emergency contact:</p>
		<table class=emergencytable>
			<tbody>
				<?php foreach($request_hotel['emergency_contact'] as $contact) { ?>
					<tr>
						<td class=firstrow>
							<?php
								echo $contact['name'].'<br />';
								$present = '';
								$present .= !empty($contact['addr_3']) ? (!empty($present) ? ', '.$contact['addr_3'].'<br />' : $contact['addr_3'].'<br />') : '';
								$present .= !empty($contact['addr_2']) ? (!empty($present) ? ', '.$contact['addr_2'].'<br />' : $contact['addr_2'].'<br />') : '';
								$present .= !empty($contact['addr_1']) ? (!empty($present) ? ', '.$contact['addr_1'].'<br />' : $contact['addr_1'].'<br />') : '';
								$present .= !empty($contact['postcode']) ? (!empty($present) ? ', '.$contact['postcode'] : $contact['postcode']) : '';
								$present .= !empty($contact['country_name']) ? (!empty($present) ? ', '.$contact['country_name'].'<br />' : $contact['country_name'].'<br />') : '';
								echo $present;
							?>
						</td>
						<td class=secondrow>t +<?php echo $contact['tel_country_code'].' '.$contact['tel'].' ('.$contact['remarks'].')'; ?></td>
						<td class=thirdrow></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>
<div class=location id=locationmap>
<div>
<div id=_id179 style="width: 500px; height: 250px" name="_id179"></div>
</div></div></div></div></div></div><span class=clearfix></span></div></div>
</body>
</html>
