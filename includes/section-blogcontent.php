<?php if ( have_posts() ): while( have_posts() ): the_post(); ?>

  <?php the_content(); ?>

  <?php 
    $fname = get_the_author_meta('first_name');
    $lname = get_the_author_meta('last_name');
    echo $fname . ' ' . $lname;
  ?>

<?php endwhile; else: endif; ?>