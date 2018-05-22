<?php
$context = Timber::get_context();

$args = array(
    // Get all posts
    'posts_per_page' => -1,
    'post_type' => 'post',
    // Order by meta value first, then order by post date
    'orderby' => 'menu_order',

    'order' => 'ASC'
);

/* Add extra data */
$context['posts'] = Timber::get_posts($args);

$args = array(
    // Get all posts
    'posts_per_page' => -1,
    'post_type' => 'jobs',
    // Order by meta value first, then order by post date
    'orderby' => 'menu_order',

    'order' => 'ASC'
);

$context['jobs'] = Timber::get_posts($args);

Timber::render('templates/index.twig', $context);