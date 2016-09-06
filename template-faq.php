<?php
/*
 * Template Name: FAQ
 * Description: A Page Template with a darker design.
 */

$context = Timber::get_context();
$context['contact'] = do_shortcode('[contact-form-7 id="72" title="Kontaktformular 1"]');

Timber::render('templates/faq.twig', $context);