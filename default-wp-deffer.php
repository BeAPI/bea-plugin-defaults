<?php

add_filter( 'option_' . 'wdjs_do_not_defer_opt', 'bea_do_not_deffer' );
add_filter( 'default_' . 'wdjs_do_not_defer_opt', 'bea_do_not_deffer' );

function bea_do_not_deffer() {
	return [ 'jquery', 'jQuery', 'flow-flow-plugin-script', 'gmap', 'recette' ];

}
