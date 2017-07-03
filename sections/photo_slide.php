<?php $image =  get_sub_field('image'); ?>
	<?php $background_image =  get_sub_field('background_image'); ?>

  <div class="container">
 

	<?php echo get_sub_field('content'); ?>


	<div class="parallax photo_slide " style="background-image: url(<?php echo $background_image['url']; ?>);"></div>

 </div>
