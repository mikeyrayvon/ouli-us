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

    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
      <div class="single-text">
        <a href="<?php the_permalink() ?>">
          <h2><?php the_title(); ?></h2>
        </a>
        <?php the_content(); ?>
      </div>
      <div class="single-images">
        
      </div>
    </article>

<?php
  }
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