<?php

/* Get post objects for select field options */
function get_post_objects( $query_args ) {
$args = wp_parse_args( $query_args, array(
    'post_type' => 'post',
) );
$posts = get_posts( $args );
$post_options = array();
if ( $posts ) {
    foreach ( $posts as $post ) {
        $post_options [ $post->ID ] = $post->post_title;
    }
}
return $post_options;
}


/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Hook in and add metaboxes. Can only happen on the 'cmb2_init' hook.
 */
add_action( 'cmb2_init', 'igv_cmb_metaboxes' );
function igv_cmb_metaboxes() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_igv_';

	/**
	 * Metaboxes declarations here
   * Reference: https://github.com/WebDevStudios/CMB2/blob/master/example-functions.php
	 */
  $images_group = new_cmb2_box( array(
    'id'           => $prefix . 'images',
    'title'        => __( 'Images', 'cmb2' ),
    'object_types' => array( 'post', ),
  ) );

  $group_images_id = $images_group->add_field( array(
    'id'          => $prefix . 'demo',
    'type'        => 'group',
    'description' => __( 'Post Images', 'cmb2' ),
    'options'     => array(
      'group_title'   => __( 'Image {#}', 'cmb2' ), // {#} gets replaced by row number
      'add_button'    => __( 'Add Another Image', 'cmb2' ),
      'remove_button' => __( 'Remove Image', 'cmb2' ),
      'sortable'      => true, // beta
      // 'closed'     => true, // true to have the groups closed by default
    ),
  ) );

  $images_group->add_group_field( $group_images_id, array(
    'name' => __( 'Image File', 'cmb2' ),
    'id'   => 'image',
    'type' => 'file',
  ) );

  $images_group->add_group_field( $group_images_id, array(
    'name' => __( 'Image Caption', 'cmb2' ),
    'id'   => 'image_caption',
    'type' => 'text',
  ) );

}
?>
