<?php 

$detail_class = '';
$detail_page = false;
if(is_single()) {
	$detail_page = true;
	$detail_class = ' detail';
}
?>

<div class="m-stats<?php echo $detail_class;?>">
	
	<div class="m-stats__col">
		

		<div class="stat-container">

			<div class="stat-container__col1">
				<img src="<?php echo IMAGES; ?>/<?php echo $skill_image; ?>">
			</div>

			<div class="stat-container__col2 stat-container__col2--border<?php echo $detail_class;?>">
				
				<div class="stat-info-container">

					<div class="stat-info-container__col1<?php echo $detail_class;?>">
						EFFORT
					</div>

					<div class="stat-info-container__col2<?php echo $detail_class;?>">
						<?php echo $skill_label;?>
					</div>

				</div>
			</div>

		</div>


	</div>

	<div class="m-stats__col">
		
		<div class="stat-container">
			<div class="stat-container__col1">
					<img src="<?php echo IMAGES; ?>/<?php echo ($detail_page==true ? 'icon_prep_sg.svg' : 'icon_prep.svg');?>">
			</div>

			<div class="stat-container__col2 stat-container__col2--border<?php echo $detail_class;?>">
				
				<div class="stat-info-container">

					<div class="stat-info-container__col1<?php echo $detail_class;?>">
						PREP TIME
					</div>

					<div class="stat-info-container__col2<?php echo $detail_class;?>">
						<?php echo $prep_time;?> MINS
					</div>

				</div>
			</div>
		</div>

	</div>

	<div class="m-stats__col">
		
		<div class="stat-container">
			<div class="stat-container__col1">


					<img src="<?php echo IMAGES; ?>/<?php echo ($detail_page==true ? 'icon_cook_sg.svg' : 'icon_cook.svg');?>">
			</div>

			<div class="stat-container__col2">
				
				<div class="stat-info-container">

					<div class="stat-info-container__col1<?php echo $detail_class;?>">
						COOK TIME
					</div>

					<div class="stat-info-container__col2<?php echo $detail_class;?>">
						<?php echo $cook_time;?> MINS
					</div>

				</div>
			</div>
		</div>

	</div>


</div>