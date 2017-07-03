<?php $search_url =  get_permalink( get_page_by_path( 'recherche' ) ); ?>
    <form id="search_form_small" method="GET" action="<?php  echo $search_url; ?>">
		<input placeholder="chercher un cours"  type="text" name="k" >
		<input type="submit" id="submit_small_search"  />
	</form>