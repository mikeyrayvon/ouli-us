<?php
// Menu icons for Custom Post Types
// https://developer.wordpress.org/resource/dashicons/
function add_menu_icons_styles(){
?>
 
<style>
#menu-posts-project .dashicons-admin-post:before {
    content: '\f319';
}
</style>
 
<?php
}
add_action( 'admin_head', 'add_menu_icons_styles' );
