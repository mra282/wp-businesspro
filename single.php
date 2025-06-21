<?php
/**
 * The template for displaying all single posts
 *
 * @package BusinessPro
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area">
            <div class="row">
                <div class="col-8">
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                            <header class="entry-header">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-featured-image">
                                        <?php
                                        the_post_thumbnail('businesspro-hero', array(
                                            'alt' => the_title_attribute(array('echo' => false)),
                                            'loading' => 'lazy',
                                        ));
                                        ?>
                                    </div><!-- .post-featured-image -->
                                <?php endif; ?>
                                
                                <div class="entry-meta">
                                    <span class="posted-on">
                                        <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                                        <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                            <?php echo esc_html(get_the_date()); ?>
                                        </time>
                                        <?php if (get_the_modified_time('U') !== get_the_time('U')) : ?>
                                            <time class="updated" datetime="<?php echo esc_attr(get_the_modified_date('c')); ?>">
                                                <?php echo esc_html(get_the_modified_date()); ?>
                                            </time>
                                        <?php endif; ?>
                                    </span>
                                    <span class="byline">
                                        <i class="fas fa-user" aria-hidden="true"></i>
                                        <span class="author vcard">
                                            <a class="url fn n" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                                <?php echo esc_html(get_the_author()); ?>
                                            </a>
                                        </span>
                                    </span>
                                    <?php if (has_category()) : ?>
                                        <span class="cat-links">
                                            <i class="fas fa-folder" aria-hidden="true"></i>
                                            <?php the_category(', '); ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="comments-link">
                                        <i class="fas fa-comments" aria-hidden="true"></i>
                                        <a href="<?php comments_link(); ?>">
                                            <?php comments_number(__('No Comments', 'businesspro'), __('1 Comment', 'businesspro'), __('% Comments', 'businesspro')); ?>
                                        </a>
                                    </span>
                                </div><!-- .entry-meta -->
                                
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                            </header><!-- .entry-header -->

                            <div class="entry-content">
                                <?php
                                the_content();

                                wp_link_pages(array(
                                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'businesspro'),
                                    'after'  => '</div>',
                                ));
                                ?>
                            </div><!-- .entry-content -->

                            <footer class="entry-footer">
                                <?php if (has_tag()) : ?>
                                    <div class="tag-links">
                                        <h4><?php esc_html_e('Tags:', 'businesspro'); ?></h4>
                                        <?php the_tags('<span class="tag-link">', '</span><span class="tag-link">', '</span>'); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="post-navigation">
                                    <?php
                                    the_post_navigation(array(
                                        'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'businesspro') . '</span> <span class="nav-title">%title</span>',
                                        'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'businesspro') . '</span> <span class="nav-title">%title</span>',
                                    ));
                                    ?>
                                </div>
                                
                                <?php if (get_edit_post_link()) : ?>
                                    <div class="edit-post-link">
                                        <?php
                                        edit_post_link(
                                            sprintf(
                                                wp_kses(
                                                    /* translators: %s: Name of current post. Only visible to screen readers */
                                                    __('Edit <span class="sr-only">%s</span>', 'businesspro'),
                                                    array(
                                                        'span' => array(
                                                            'class' => array(),
                                                        ),
                                                    )
                                                ),
                                                get_the_title()
                                            ),
                                            '<span class="edit-link">',
                                            '</span>'
                                        );
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </footer><!-- .entry-footer -->
                        </article><!-- #post-<?php the_ID(); ?> -->

                        <?php
                        // Author bio section
                        if (get_the_author_meta('description')) :
                        ?>
                            <div class="author-info">
                                <div class="author-avatar">
                                    <?php
                                    echo get_avatar(get_the_author_meta('user_email'), 80, '', get_the_author());
                                    ?>
                                </div>
                                <div class="author-description">
                                    <h3 class="author-title">
                                        <?php
                                        printf(
                                            /* translators: %s: post author */
                                            esc_html__('About %s', 'businesspro'),
                                            '<span class="author-heading">' . get_the_author() . '</span>'
                                        );
                                        ?>
                                    </h3>
                                    <p class="author-bio">
                                        <?php echo wp_kses_post(get_the_author_meta('description')); ?>
                                        <a class="author-link" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author">
                                            <?php
                                            printf(
                                                /* translators: %s: post author */
                                                esc_html__('View all posts by %s', 'businesspro'),
                                                get_the_author()
                                            );
                                            ?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        if (comments_open() || get_comments_number()) :
                            comments_template();
                        endif;
                        ?>

                    <?php endwhile; // End of the loop. ?>
                </div><!-- .col-8 -->

                <div class="col-4">
                    <?php get_sidebar(); ?>
                </div><!-- .col-4 -->
            </div><!-- .row -->
        </div><!-- .content-area -->
    </div><!-- .container -->
</main><!-- #main -->

<?php
get_footer();
