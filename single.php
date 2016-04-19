<?php
get_header();
?>

<!-- main content -->

<main id="main-content">

  <!-- main posts loop -->
  <section id="posts" class="container">

<?php
if( have_posts() ) {
  while( have_posts() ) {
    the_post();
?>

    <article <?php post_class('text-align-center'); ?> id="post-<?php the_ID(); ?>">
      <div class="single-text">
        <a href="<?php the_permalink() ?>">
          <h1><?php the_title(); ?></h1>
        </a>
        <?php the_content(); ?>
      </div>
<?php 
  $images_data = get_post_meta($post->ID, '_igv_images');
  $images = $images_data[0];

  if ($images) {
    foreach($images as $image) {

      $image_id = $image['image_id'];
      $image_size = get_random_image_size();
      $image_width = get_option( "{$image_size}_size_w" );
      $image_src = wp_get_attachment_image_src( $image_id, $image_size )[0];

      ?>

        <div class="single-image" style="max-width:<?php echo $image_width; ?>px;">
          <img src="<?php echo $image_src; ?>" />
        <?php if ( array_key_exists('image_caption', $image) ) { ?>
          <div class="caption"><?php echo $image['image_caption']; ?></div>
        <?php } ?>
        </div>

      <?php

    } // end foreach
  } // end if
?>
    </article>

<?php
  }
} else {
?>
    <article class="u-alert"><?php _e('Sorry, this post does not exist.'); ?></article>
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