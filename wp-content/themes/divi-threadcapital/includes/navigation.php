<?php
  the_posts_pagination([
    'prev_text' => '&laquo; ' . __('Previous', 'divi-thread') . '<span class="screen-reader-text">' . __('page', 'divi-thread') . '</span>',
    'next_text' => __('Next', 'divi-thread') . ' <span class="screen-reader-text">' . __('page', 'divi-thread') . '</span> &raquo;',
    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'divi-thread') . '</span>',
  ]);
?>
