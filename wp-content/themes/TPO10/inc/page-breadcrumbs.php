<?php
if(!function_exists('breadcrumbs_lesson_course')){
    function breadcrumbs_lesson_course($post_id){
        $course_id = learndash_get_course_id($post_id);
        $post = get_post($course_id);
        return $post;
    }
}
if(!function_exists("breadcrumbs_topic_lesson")){
    function breadcrumbs_topic_lesson($post_id){
        $lesson_id = learndash_get_lesson_id($post_id);
        $post = get_post($lesson_id);
        return $post;
    }
}
?>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="<?php echo site_url() ?>">Home</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <?php
            $link ='';
            if(empty($post->post_parent)){
                $postType = get_post_type($post);
                switch($postType){
                    case "sfwd-courses":
                        $obj = get_post_type_object( $postType );
                        $link .= '<a href="/training/'.$obj->rewrite['slug'].'">'.$obj->labels->name.'</a><i class="fa fa-angle-right"></i>';
                        break;
                    case "sfwd-lessons":
                    case "sfwd-quiz":
                        $lesson_course = breadcrumbs_lesson_course($post->ID);
                        $link .= '<a href="'.$lesson_course->post_name.'">'.$lesson_course->post_title.'</a><i class="fa fa-angle-right"></i>';
                        break;
                    case "sfwd-topic":
                        $lesson_course = breadcrumbs_lesson_course($post->ID);
                        $link .= '<a href="'.$lesson_course->post_name.'">'.$lesson_course->post_title.'</a><i class="fa fa-angle-right"></i>';

                        $topic_lesson = breadcrumbs_topic_lesson($post->ID);
                        $link .= '<a href="'.$topic_lesson->post_name.'">'.$topic_lesson->post_title.'</a><i class="fa fa-angle-right"></i>';
                        break;
                }
                $link .= '<a href="'.$post->post_name.'">'.get_the_title( $post->ID ).'</a>';
            }else {
                $ancestors = get_post_ancestors( $post );

                foreach($ancestors as $ancestor){
                    $link .= '<a href="'.get_page_template_slug( $ancestor ).'">'.get_the_title($ancestor).'</a><i class="fa fa-angle-right"></i>';
                }

                $link .= '<a href="'.$post->post_name.'">'.get_the_title( $post->ID ).'</a>';

            }
            echo $link;
            ?>

        </li>
    </ul>

</div>