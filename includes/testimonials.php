<?php
function manifesto_testimonials_shortcode() {
     ob_start();
?>
<div class="uk-margin" data-uk-slideset="{default: 1}">
    <div class="uk-slidenav-position uk-margin-large-bottom">
        <ul class="uk-slideset uk-grid uk-flex-center">
           <?php
           $arg = array(
                'post_type' => 'testimonial',
                'posts_per_page' => -1
            );
            $query = new WP_Query( $arg );
            if ( $query->have_posts() ) {
            while( $query->have_posts() ) : $query->the_post();
            ?>
            <li class="uk-width-3-5">
                <blockquote>
                    <?php the_content(); ?>
                    <?php if ( has_post_thumbnail() ) the_post_thumbnail( 'testimonial' ); ?>
                    <cite class="uk-display-block uk-text-right"><?php the_title(); ?></cite>
                    <span class="quote">“</span>
                </blockquote>
            </li>
            <?php
            endwhile;
            }
            wp_reset_postdata(); ?>
        </ul>
    </div>
</div>
<?php
    $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;
}
add_shortcode( 'testimonials', 'manifesto_testimonials_shortcode' );
