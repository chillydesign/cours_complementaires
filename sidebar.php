



<div class="sidebar-widget">
	<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-1')) ?>
</div>



<?php 
$donate_page = get_page_by_title( 'Donate' );
$volunteer_page = get_page_by_title( 'Volunteer' );
$donate_id = $donate_page->ID;
$volunteer_id = $volunteer_page->ID;

?>

<a class="button button-block button-yellow" href="<?php echo get_page_link($donate_id); ?>"><?php _e( 'Donate', 'llyn' ); ?></a>
<a  class="button button-block button-orange" href="<?php echo get_page_link($volunteer_id); ?>"><?php _e( 'Volunteer', 'llyn' ); ?></a>