<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');




function send_mail()
{
    $error = '';
    $status = 'error';
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['message'])) {
        $error = 'All fields are required to enter.';
        //wp_die($error);
    } else {
        if (!wp_verify_nonce($_POST['_acf_nonce'], $_POST['action'])) {
            $error = 'Verification error, try again.';
        } else {
            $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $subject = stripslashes($_POST['project']);
            $message = stripslashes($_POST['message']) . PHP_EOL ;
            $message .= $_POST['phone-country'].$_POST['phone-prefix'].$_POST['phone-number'];
            $message .= PHP_EOL . PHP_EOL . 'IP address: ' . $_SERVER['REMOTE_ADDR'];
            $message .= PHP_EOL . 'Sender\'s name: ' . $name;
            $message .= PHP_EOL . 'E-mail address: ' . $email;
            $to = get_option('admin_email'); // If you like change this email address
            // replace "noreply@yourdomain.com" with your real email address
            $header = 'From: ' . get_option('blogname') . ' <noreply@byintention.de>' . PHP_EOL;
            $header .= 'Reply-To: ' . $email . PHP_EOL;
            if (wp_mail($to, $subject, $message, $header)) {
                $status = 'success';
                $error = null;
            } else {
                $error = 'Some errors occurred.';
            }
        }
    }
    header("Content-Type: application/json");

    if ($error) {
        wp_die('Asd');
        header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
        wp_die();
    }
    header($_SERVER['SERVER_PROTOCOL'] . ' 200');
    $resp = array('status' => $status, 'errmessage' => $error);
    return json_encode($resp);
    wp_die();
}

add_action('wp_ajax_nopriv_post_action', __NAMESPACE__ . '\\send_mail');
add_action('wp_ajax_post_action', __NAMESPACE__ . '\\send_mail');
