<?php if ( have_posts() ): while( have_posts() ): the_post(); ?>

  <?php echo get_the_date('l jS F, Y'); ?>

  <?php the_content(); ?>

  <?php 
    $fname = get_the_author_meta('first_name');
    $lname = get_the_author_meta('last_name');
  ?>

  <p>Posted by: <?php echo $fname; ?> <?php echo $lname; ?></p>

  <?php
  $tags = get_the_tags();
  $categories = get_categories();
  ?>

  <?php foreach ( $tags as $tag ): ?>

    <a href="<?php echo get_tag_link( $tag->term_id ); ?>" class="badge bg-success">
      <?php echo $tag->name; ?>
    </a>
  
  <?php endforeach; ?>

  <?php foreach ( $categories as $category): ?>
    <a href="<?php echo get_category_link( $category->term_id ); ?>">
      <?php echo $category->name; ?>
    </a>

  <?php endforeach; ?>
  
<?php endwhile; else: endif; ?>
