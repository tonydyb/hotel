<?php if ($paginator->hasPage(2)) {?>
<div style="clear:both; padding-bottom:5px;"></div>
<div class="paging">
	<?php $paginator->options(array('url' => $this->passedArgs)); ?>
	<div style="float:left;padding-right:10px;"><?php echo $paginator->first('<< '.__('first', true), array(), null, array('class'=>'disabled'));?></div>
	<div style="float:left;padding-right:10px;"><?php echo $paginator->prev('< '.__('previous', true), array(), null, array('class'=>'disabled'));?></div>
	<div style="float:left;padding-right:10px;"><?php echo $paginator->numbers();?></div>
	<div style="float:left;padding-right:10px;"><?php echo $paginator->next(__('next', true).' >', array(), null, array('class' => 'disabled'));?></div>
	<div style="float:left;padding-right:10px;"><?php echo $paginator->last(__('last', true).' >>', array(), null, array('class' => 'disabled'));?></div>
</div>

<?php } ?>