<?php
/**
 * The main template file
 *
 * @package BusinessPro
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <div class="content-area">
            <header class="page-header">
                <h1 class="page-title">
                    <?php
                    if (is_home() && !is_front_page()) {
                        esc_html_e('Blog', 'businesspro');
                    } elseif (is_archive()) {
                        the_archive_title();
                    } elseif (is_search()) {
                        printf(
                            /* translators: %s: search query */
                            esc_html__('Search Results for: %s', 'businesspro'),
                            '<span>' . get_search_query() . '</span>'
                        );
                    } else {
                        esc_html_e('Latest Posts', 'businesspro');
                    }
                    ?>
                </h1>
                <?php
                if (is_archive()) {
                    the_archive_description('<div class="archive-description">', '</div>');
                }
                ?>
            </header><!-- .page-header -->

            <div class="row">
                <div class="col-8">
                    <?php if (have_posts()) : ?>
                        <div class="posts-grid">
                            <?php while (have_posts()) : the_post(); ?>
                                <article id="post-<?php the_ID(); ?>" <?php post_class('blog-post-card'); ?>>
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="post-thumbnail">
                                            <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
                                                <?php
                                                the_post_thumbnail('businesspro-portfolio', array(
                                                    'alt' => the_title_attribute(array('echo' => false)),
                                                    'loading' => 'lazy',
                                                ));
                                                ?>
                                            </a>
                                        </div><!-- .post-thumbnail -->
                                    <?php endif; ?>

                                    <div class="post-content">
                                        <header class="entry-header">
                                            <div class="entry-meta">
                                                <span class="posted-on">
                                                    <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                                                    <time class="entry-date published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                                        <?php echo esc_html(get_the_date()); ?>
                                                    </time>
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
                                            </div><!-- .entry-meta -->

                                            <h2 class="entry-title">
                                                <a href="<?php the_permalink(); ?>" rel="bookmark">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h2>
                                        </header><!-- .entry-header -->

                                        <div class="entry-summary">
                                            <?php the_excerpt(); ?>
                                        </div><!-- .entry-summary -->

                                        <footer class="entry-footer">
                                            <a href="<?php the_permalink(); ?>" class="btn btn-outline">
                                                <?php esc_html_e('Read More', 'businesspro'); ?>
                                                <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                            </a>
                                            
                                            <?php if (has_tag()) : ?>
                                                <div class="tag-links">
                                                    <i class="fas fa-tags" aria-hidden="true"></i>
                                                    <?php the_tags('', ', '); ?>
                                                </div>
                                            <?php endif; ?>
                                        </footer><!-- .entry-footer -->
                                    </div><!-- .post-content -->
                                </article><!-- #post-<?php the_ID(); ?> -->
                            <?php endwhile; ?>
                        </div><!-- .posts-grid -->

                        <?php
                        // Pagination
                        the_posts_pagination(array(
                            'mid_size'  => 2,
                            'prev_text' => '<i class="fas fa-chevron-left" aria-hidden="true"></i> ' . __('Previous', 'businesspro'),
                            'next_text' => __('Next', 'businesspro') . ' <i class="fas fa-chevron-right" aria-hidden="true"></i>',
                        ));
                        ?>

                    <?php else : ?>
                        <section class="no-results not-found">
                            <header class="page-header">
                                <h1 class="page-title"><?php esc_html_e('Nothing here', 'businesspro'); ?></h1>
                            </header><!-- .page-header -->

                            <div class="page-content">
                                <?php if (is_home() && current_user_can('publish_posts')) : ?>
                                    <p>
                                        <?php
                                        printf(
                                            wp_kses(
                                                /* translators: 1: link to WP admin new post page */
                                                __('Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'businesspro'),
                                                array(
                                                    'a' => array(
                                                        'href' => array(),
                                                    ),
                                                )
                                            ),
                                            esc_url(admin_url('post-new.php'))
                                        );
                                        ?>
                                    </p>
                                <?php elseif (is_search()) : ?>
                                    <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'businesspro'); ?></p>
                                    <?php get_search_form(); ?>
                                <?php else : ?>
                                    <p><?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'businesspro'); ?></p>
                                    <?php get_search_form(); ?>
                                <?php endif; ?>
                            </div><!-- .page-content -->
                        </section><!-- .no-results -->
                    <?php endif; ?>
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
