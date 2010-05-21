<?php if (!is_null($room_data)) { ?>
<?php

if ($is_color == 1) {
	$back_color = ' color_silver';
	$back_class = 'class="color_silver" ';
}

$count = $room_data['room_data']['count'];

?>
<table>
	<tr>
		<th class="font-size10pt"><?php __('食事'); ?></th>
		<td class="font-size10pt<?php echo $back_color; ?>">
			<?php
				$opt = array();
				foreach ($meal_type as $mt) {
					$opt[trim($mt['mtl']['meal_type_id'])] = $mt['mtl']['name'];
				}
				echo ($form->input('RequestHotel.'.$count.'.meal_type_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $room_data['room_data']['meal_type_id'])));
			?>
		</td>
		<th class="font-size10pt"><?php __('朝食'); ?></th>
		<td class="font-size10pt<?php echo $back_color; ?>">
			<?php
				$opt = array();
				foreach ($breakfast_type as $bt) {
					$opt[trim($bt['btl']['breakfast_type_id'])] = $bt['btl']['name'];
				}
				echo ($form->input('RequestHotel.'.$count.'.breakfast_type_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $room_data['room_data']['breakfast_type_id'])));
			?>
		</td>
	</tr>
	<tr>
		<th class="font-size10pt"><?php __('風呂'); ?></th>
		<td colspan="3" class="font-size10pt<?php echo $back_color; ?>">
			<?php
				echo $room_data['room_data']['bath_name'];
				echo $form->input('RequestHotel.'.$count.'.bath_name', array('type'=>'hidden', 'value'=>$room_data['room_data']['bath_name']));
			?>
		</td>
	</tr>
	<tr>
		<th class="font-size10pt"><?php __('料金(参考)'); ?></th>
		<td class="font-size10pt<?php echo $back_color; ?>">
			<?php
				echo $form->text('RequestHotel.'.$count.'.price', array('size' => '30', 'value'=>$room_data['room_data']['price']));
				echo $form->input('RequestHotel.'.$count.'.point', array('type'=>'hidden', 'value'=>$room_data['room_data']['point']));
			?>
		</td>
		<th class="font-size10pt"><?php __('通貨'); ?></th>
		<td class="font-size10pt<?php echo $back_color; ?>">
			<?php
				$opt = array();
				foreach ($currency as $cur) {
					$opt[trim($cur['currency']['currency_id'])] = $cur['currency']['iso_code_a'].CURRENCY_DELIMITER.$cur['currency']['currency_name'];
				}
				echo debug($currency);
				echo ($form->input('RequestHotel.'.$count.'.currency_id', array('type' => 'select', 'options' => $opt, 'label'=>'', 'div' => false, 'selected' => $room_data['room_data']['currency_id'])));
			?>
		</td>
	</tr>
</table>
<?php } ?>
