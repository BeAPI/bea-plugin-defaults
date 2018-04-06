<?php function addtoany_disable_sharing_on_my_custom_post_type() {
	return true;
}
add_filter( 'addtoany_sharing_disabled', 'addtoany_disable_sharing_on_my_custom_post_type' );
