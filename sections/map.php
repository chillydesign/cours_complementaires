
<?php $search_url =  get_permalink( get_page_by_path( 'recherche' ) ); ?>


<div id="zone_map_outer" style="margin-bottom: -50px">
<div id="zone_map_container" >


</div>

</div>

<script type="text/javascript">
	var zone_locations = <?php zones_for_map(); ?>;
	var search_url = '<?php echo $search_url; ?>';
</script>
<?php if (false): ?>

<div id="location_box">
	<h3 id="lb_school_name">School Name</h3>
	<a  data-url="<?php echo $search_url; ?>" href="" id="lb_school_link">Voir les cours</a>
</div>

<?php endif; ?>