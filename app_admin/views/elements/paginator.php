<div id='pagination'>
<?php
	echo __('【該当'.$paginator->params['paging']['CustomerUser']['count'].'件】');
	echo $paginator->first(__('最初', true), array('after'=>'&nbsp;&nbsp;','class'=>'paging_inner' ));
	echo $paginator->prev('« '.__('', true), array(), null, array('class'=>'disabled', 'tag' => 'span'));
 ?>
 |
 <?php
 	if ( $paginator->params['paging']['CustomerUser']['count'] <= CUS_VIEW_MAX) {
 		echo '1';
 	}
 ?>
 <?php
	echo $paginator->numbers().' | '.$paginator->next(__('', true).' »', array(), null, array('tag' => 'span', 'class' => 'disabled'));
	echo $paginator->last(__('最後', true),array('before'=>'&nbsp;&nbsp;','class'=>'paging_inner' ) );
	?>
</div>
