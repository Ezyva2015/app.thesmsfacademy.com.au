<?php

function my_gform_filter($content) {
    return $content.'[gravitylist id=63 title=false description=false]';
}

add_filter( 'the_content', 'my_gform_filter', 1, 1 );