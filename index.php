<?php
get_header();
?>

<!-- main content -->

<main id="main-content">

  <!-- main posts loop -->
  <section id="posts" class="container images-container">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();

    $image_id = get_post_thumbnail_id( $post->ID );

    if ($image_id) {

      $image_size = get_random_image_size();
      $image_width = get_option( "{$image_size}_size_w" );
      $image_src = wp_get_attachment_image_src( $image_id, $image_size )[0];

?>

    <article <?php post_class('single-image'); ?> style="max-width: <?php echo $image_width; ?>px" id="post-<?php the_ID(); ?>">
      <a href="<?php the_permalink() ?>">

        <img src="<?php echo $image_src; ?>" />

        <h2><?php the_title(); ?></h2>

      </a>
    </article>

<?php
    } //end if
  } // end while
} else {
?>
    <article class="u-alert"><?php _e('Sorry, no posts matched your criteria :{'); ?></article>
<?php
} ?>

  <!-- end posts -->
  </section>

  <?php get_template_part('partials/pagination'); ?>

<!-- end main-content -->

</main>

<?php
get_footer();
?>