<?php
/**
 * File: category.php
 * Theme: Gary Wallage Wedding Pro
 * Description: Custom Gallery Layouts driven by Customizer settings.
 */

get_header(); 

$current_category = get_queried_object();

// Get the user's preferred layout from Customizer (default: masonry)
$layout_type = get_theme_mod( 'category_layout_type', 'masonry' );
$layout_class = 'layout-' . $layout_type;
?>

<main id="primary" class="site-main container">

    <header class="archive-header" style="text-align:center; margin-bottom:60px;">
        <span style="font-family:'Blacksword', serif; color:var(--wedding-accent); font-size:2rem;">Collection</span>
        <h1 class="entry-title" style="font-size:3.5rem; margin-top:10px;"><?php single_cat_title(); ?></h1>
        <?php if ( category_description() ) : ?>
            <div class="archive-meta" style="max-width:600px; margin:20px auto; opacity:0.8;">
                <?php echo category_description(); ?>
            </div>
        <?php endif; ?>
    </header>

    <?php if ( have_posts() ) : ?>
        <div class="blog-grid">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php the_excerpt(); ?>
                </article>
            <?php endwhile; ?>
        </div>
    <?php else : 
        
        $image_query = new WP_Query( array(
            'post_type'      => 'attachment',
            'post_status'    => array('inherit', 'publish'),
            'post_mime_type' => 'image',
            'posts_per_page' => 50,
            'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => $current_category->slug,
                ),
            ),
        ));

        if ( $image_query->have_posts() ) : ?>
            
            <!-- Dynamic Layout Class Here -->
            <div class="visual-legacy-grid <?php echo esc_attr( $layout_class ); ?>">
                <?php while ( $image_query->have_posts() ) : $image_query->the_post(); ?>
                    <div class="gallery-item">
                        <a href="<?php echo wp_get_original_image_url( get_the_ID() ); ?>" class="lightbox-trigger">
                            <?php 
                            echo wp_get_attachment_image( get_the_ID(), 'medium_large', false, array( 'class' => 'gallery-img' ) ); 
                            ?>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="pagination" style="text-align:center; margin-top:60px;">
                <?php 
                echo paginate_links( array(
                    'total' => $image_query->max_num_pages,
                    'current' => max( 1, get_query_var('paged') ),
                    'prev_text' => '&larr; Previous',
                    'next_text' => 'Next &rarr;',
                ) ); 
                ?>
            </div>

            <?php wp_reset_postdata(); ?>

        <?php else : ?>
            <p style="text-align:center; padding:100px 0;">No images found in this collection.</p>
        <?php endif; ?>

    <?php endif; ?>

</main>

<?php get_footer(); ?>
