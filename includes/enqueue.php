<?php

add_action('admin_enqueue_scripts', function () {
    # wp included libraries
    wp_enqueue_script('jquery');

    # backalley scripts
    wp_enqueue_script('backalley-core-admin-script', BackAlley::$url . 'assets/js/backalley-admin.js', null, time(), true);
    
    # backalley styles
    wp_enqueue_style('backalley-core-styles', BackAlley::$url . 'assets/css/backalley-admin-styles.css', null, time());
});