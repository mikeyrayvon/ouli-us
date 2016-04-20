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

    $image_id = get_post_thumbnail_id( $post->ID );
    $post_num = 1;

    if ($image_id) {

      $image_size = get_random_image_size();
      $image_width = get_option( "{$image_size}_size_w" );
      $image_src = wp_get_attachment_image_src( $image_id, $image_size )[0];

?>

    <article <?php post_class('single-image'); ?> style="max-width: <?php echo $image_width; ?>px" id="post-<?php the_ID(); ?>">
      <a class="post-link" href="<?php the_permalink() ?>">

        <img src="<?php echo $image_src; ?>" />

        <div class="post-title text-align-center">
          <div class="post-num"><?php echo $post_num; ?></div>
          <h2><?php the_title(); ?></h2>
        </div>

      </a>
    </article>

<?php
      $post_num++;
    } //end if
  } // end while
} else {
?>
    <article class="u-alert"><?php _e('Not found.'); ?></article>
<?php
} ?>

  <!-- end posts -->
  </section>

  <section id="home-text-container" class="container">
    <?php 
      $text = IGV_get_option('_igv_home_text');
      $email = IGV_get_option('_igv_email');
      
      if ( $text ) { 
        echo '<div class="home-text">' . $text . '</div>';
      }

      if ( $email ) { 
        echo '<a href="mailto:' . $email . '">' . $email . '</a>';
      }

    ?>
  </section>

<!-- end main-content -->

</main>

<?php
get_footer();
?>