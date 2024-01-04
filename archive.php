<?php get_header();  ?>

<section class="page-wrap">
<div class="container">
  
  <?php get_template_part('includes/section', 'archive'); ?>

  <?php

  global $wp_query;

  $big = 999999999; // need an unlikely integer

  echo paginate_links([
    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
    'format' => '?paged=%#%',
    'current' => max( 1, get_query_var( 'paged' ) ),
    'total' => $wp_query->max_num_pages
  ]);
  ?>


  <?php //previous_posts_link(); ?>
  <?php //next_posts_link(); ?>

</div>
</section>

<?php get_footer();  ?>
