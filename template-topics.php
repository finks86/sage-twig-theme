<?php
/*
 * Template Name: Themen
 * Description: A Page Template with a darker design.
 */

$context = Timber::get_context();
//$context['groups'] = Timber::get_terms('groups');

Timber::render('templates/topics.twig', $context);