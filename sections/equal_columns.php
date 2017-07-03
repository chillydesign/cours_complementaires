<?php $column_count =  sizeof(  get_sub_field('column')  ); ?>
<?php $column_class = count_to_bootstrap_class($column_count); ?>


<div class="container">
	<div class="row">
	<?php while ( have_rows('column') ) : the_row(); ?>
		<div class="<?php echo $column_class; ?>">
			<?php echo get_sub_field('column_content'); ?>
		</div>
	<?php endwhile; ?>
	</div> <!-- END OF ROW -->
</div><!--  END OF CONTAINER -->
