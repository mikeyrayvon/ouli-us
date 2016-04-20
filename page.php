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
    $info_heading = get_post_meta($post->ID, '_igv_info_heading');
    $email = IGV_get_option('_igv_email');
    $email_array = explode('@', $email);
?>

    <article <?php post_class('single-text'); ?> id="post-<?php the_ID(); ?>">
<?php 
        if ($info_heading || $email) { 
          echo '<div class="info-header">'; 
        
          if ( $info_heading ) { 
            echo '<h1 class="info-title">' . $info_heading[0] . '</h1>'; 
          } 
          if ( $email ) { 
            echo '<a class="info-email" href="mailto:' . $email . '">';
            echo '<span class="font-underline">' . $email_array[0] . '</span>@';
            echo '<span class="font-underline">' . $email_array[1] . '</span></a>';
          }

          echo '</div>';
        }
?>

      <?php the_content(); ?>
    </article>

<?php
  } // end while
} else {
?>
    <article class="u-alert"><?php _e('Not found.'); ?></article>
<?php
} ?>

  <!-- end posts -->
  </section>

<!-- end main-content -->

</main>

<?php
get_footer();
?>