<?php $search_url =  get_permalink( get_page_by_path( 'recherche' ) ); ?>


<div class="container">

	<div class="flex_container">

		<div class="flex_grow_1 categ_electro category_box"><a href="<?php echo $search_url . '#c=9'; ?>">Musique électro-acoustique et informatique musicale</a></div>

		<div class="flex_container flex_column">
			<div class="flex_grow_1 categ_improv category_box"><a href="<?php echo $search_url . '#c=10'; ?>">Improvisation – Harmonie pratique – Accompagnement</a></div>
			<div class="flex_grow_1 categ_ensemble category_box"><a href="<?php echo $search_url . '#c=4'; ?>">Ensembles – Orchestres – Musique de chambre</a></div>
		</div>
	</div>

	
	<div class="flex_container">
		<div class="flex_grow_1">

			<div class="flex_container flex_column">
				<div class="flex_grow_1 categ_ancienne smaller_flex category_box"><a href="<?php echo $search_url . '#c=5'; ?>">Musique ancienne</a></div>
				<div class="flex_grow_2 categ_corps bigger_flex category_box"><a href="<?php echo $search_url . '#c=6'; ?>">Corps – Mouvement</a></div>
			</div>

		</div>
		<div class="flex_grow_2">
			<div class="flex_container">
				<div class="flex_grow_1 categ_jazz category_box"><a href="<?php echo $search_url . '#c=11'; ?>">Jazz</a></div>
				<div class="flex_grow_1 categ_composition category_box"><a href="<?php echo $search_url . '#c=7'; ?>">Culture musicale – Composition</a></div>
			</div>
			<div class="flex_container">
				<div class="flex_grow_1 categ_instrumentale category_box"><a href="<?php echo $search_url . '#c=8'; ?>">Culture instrumentale</a></div>
				<div class="flex_grow_1 categ_voix category_box"><a href="<?php echo $search_url . '#c=3'; ?>">Voix</a></div>
			</div>
		</div>
	</div>


</div>


