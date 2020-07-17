<?php 
	
	$config_content_width = 'Wide';
	$intro = '';
	$content = '';

	$config_content_width = get_sub_field('config_content_width');
	$width_class = ($config_content_width == "Narrow" ? ' section-intro-container--narrow' : '');
	$intro = get_sub_field('intro');
	$content = get_sub_field('content');

	$intro_margin_class = ($intro!='' && $content!='' ? 'section-intro--m-bottom ' : '');
?>


<div class="section-intro-container<?php echo $width_class;?>">

	<?php if($intro) { ?>
		<div class="section-intro <?php echo $intro_margin_class;?> "><?php echo $intro;?></div>
	<?php } ?>

	<?php if($content) { ?>
		<div class="section-intro-content"><?php echo $content;?></div>
	<?php } ?>

</div>