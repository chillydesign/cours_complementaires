<?php $icon_count =  sizeof(  get_sub_field('icon')  ); ?>
<?php  $icon_class = count_to_bootstrap_class($icon_count); ?>



<div class="container">

	<?php $introduction_content =  get_sub_field('introduction_content'); ?>
	<div class="introduction_content">
		<?php echo $introduction_content; ?>
	</div>

	<div class="row">
		<?php while ( have_rows('icon') ) : the_row() ; ?>
			<?php $image =  get_sub_field('image'); ?>
			<?php $text =  get_sub_field('text'); ?>
			<?php $link =  get_sub_field('link'); ?>
		

			<a href="<?php echo $link; ?>#"  class="<?php echo $icon_class; ?>  icon_column" > 
				<img src="<?php echo   $image['url']; ?>" alt="" />
				<?php echo $text; ?>
			</a>
		<?php endwhile; ?>

	</div> <!-- END OF ROW -->
</div><!--  END OF CONTAINER -->

