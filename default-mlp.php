<?php add_filter( 'pre_site_option_state_modules', function () {
	return [
		'class-Mlp_Cpt_Translator'                    => 'off',
		'class-Mlp_Advanced_Translator'               => 'off',
		'class-Mlp_Alternative_Language_Title_Module' => 'off',
		'class-Mlp_Quicklink'                         => 'off',
		'class-Mlp_Redirect_Registration'             => 'on',
		'class-Mlp_Trasher'                           => 'off',
	];
} );
