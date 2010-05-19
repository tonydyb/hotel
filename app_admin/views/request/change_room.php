<?php if (!is_null($room_data)) { ?>
<table>
	<tr>
		<th class="font-size10pt"><?php __('食事'); ?></th>
		<td class="font-size10pt">
			<?php
				echo $room_data['room_data']['meal_name'];
			?>
		</td>
		<th class="font-size10pt"><?php __('朝食'); ?></th>
		<td class="font-size10pt">
			<?php
				echo $room_data['room_data']['breakfast_name'];
			?>
		</td>
	</tr>
	<tr>
		<th class="font-size10pt"><?php __('風呂'); ?></th>
		<td colspan="3" class="font-size10pt">
			<?php
				echo $room_data['room_data']['bath_name'];
			?>
		</td>
	</tr>
	<tr>
		<th class="font-size10pt"><?php __('料金(参考)'); ?></th>
		<td class="font-size10pt">
			<?php
				echo $number->format($room_detail['room_data']['price'], array('places' => PRICE_PLACES, 'before' => false, 'escape' => false, 'decimals' => '.', 'thousands' => ','));
				echo $form->input('RequestData.RequestHotel.'.$room_data['room_data']['count'].'.price', array('type'=>'hidden', 'value'=>$room_data['room_data']['price']));
				echo $form->input('RequestData.RequestHotel.'.$room_data['room_data']['count'].'.point', array('type'=>'hidden', 'value'=>$room_data['room_data']['point']));
				?>
		</td>
		<th class="font-size10pt"><?php __('通貨'); ?></th>
		<td class="font-size10pt">
			<?php
				echo $room_data['room_data']['currency_name'];
				echo $form->input('RequestData.RequestHotel.'.$room_data['room_data']['count'].'.currency_id', array('type'=>'hidden', 'value'=>$room_data['room_data']['currency_id']));
			?>
		</td>
	</tr>
</table>
<?php } ?>
