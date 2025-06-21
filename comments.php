<?php
/**
 * Comments Template
 * 
 * The template for displaying comments
 *
 * @package BusinessPro
 * @since 1.0.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    /* translators: 1: title. */
                    esc_html__('One thought on &ldquo;%1$s&rdquo;', 'businesspro'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    /* translators: 1: comment count number, 2: title. */
                    esc_html(_nx('%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'businesspro')),
                    number_format_i18n($comment_count), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2>

        <!-- Comment Navigation -->
        <?php the_comments_navigation(array(
            'prev_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><polyline points="15,18 9,12 15,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> ' . __('Older Comments', 'businesspro'),
            'next_text' => __('Newer Comments', 'businesspro') . ' <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><polyline points="9,18 15,12 9,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        )); ?>

        <!-- Comments List -->
        <ol class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ol',
                'short_ping'  => true,
                'avatar_size' => 60,
                'callback'    => 'businesspro_comment_callback',
            ));
            ?>
        </ol>

        <!-- Comment Navigation -->
        <?php the_comments_navigation(array(
            'prev_text' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><polyline points="15,18 9,12 15,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> ' . __('Older Comments', 'businesspro'),
            'next_text' => __('Newer Comments', 'businesspro') . ' <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><polyline points="9,18 15,12 9,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        )); ?>

        <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if (!comments_open()) :
            ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'businesspro'); ?></p>
        <?php endif; ?>

    <?php endif; // Check for have_comments(). ?>

    <?php
    // Comment Form
    $comment_form_args = array(
        'title_reply'          => __('Leave a Comment', 'businesspro'),
        'title_reply_to'       => __('Leave a Reply to %s', 'businesspro'),
        'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
        'title_reply_after'    => '</h3>',
        'cancel_reply_link'    => __('Cancel Reply', 'businesspro'),
        'cancel_reply_before'  => ' <small>',
        'cancel_reply_after'   => '</small>',
        'comment_notes_before' => '<p class="comment-notes">' . __('Your email address will not be published. Required fields are marked *', 'businesspro') . '</p>',
        'comment_notes_after'  => '',
        'class_form'           => 'comment-form',
        'class_submit'         => 'btn btn-primary submit-comment',
        'submit_button'        => '<button type="submit" id="%2$s" class="%3$s">%4$s</button>',
        'submit_field'         => '<div class="form-submit">%1$s %2$s</div>',
        'format'               => 'xhtml',
        'fields' => array(
            'author' => '<div class="comment-form-author">' .
                        '<label for="author">' . __('Name *', 'businesspro') . '</label>' .
                        '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245" required="required" />' .
                        '</div>',
            'email'  => '<div class="comment-form-email">' .
                        '<label for="email">' . __('Email *', 'businesspro') . '</label>' .
                        '<input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30" maxlength="100" aria-describedby="email-notes" required="required" />' .
                        '</div>',
            'url'    => '<div class="comment-form-url">' .
                        '<label for="url">' . __('Website', 'businesspro') . '</label>' .
                        '<input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" maxlength="200" />' .
                        '</div>',
        ),
        'comment_field' => '<div class="comment-form-comment">' .
                          '<label for="comment">' . __('Comment *', 'businesspro') . '</label>' .
                          '<textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" placeholder="' . esc_attr__('Share your thoughts...', 'businesspro') . '"></textarea>' .
                          '</div>',
    );

    comment_form($comment_form_args);
    ?>
</div><!-- #comments -->

<?php
/**
 * Custom comment callback function
 */
if (!function_exists('businesspro_comment_callback')) :
    function businesspro_comment_callback($comment, $args, $depth) {
        if ('div' === $args['style']) {
            $tag       = 'div';
            $add_below = 'comment';
        } else {
            $tag       = 'li';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo $tag; ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID(); ?>">
        <?php if ('div' != $args['style']) : ?>
            <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
        <?php endif; ?>
        
        <div class="comment-meta">
            <div class="comment-avatar">
                <?php
                if ($args['avatar_size'] != 0) {
                    echo get_avatar($comment, $args['avatar_size']);
                }
                ?>
            </div>
            
            <div class="comment-metadata">
                <div class="comment-author-name">
                    <?php
                    $comment_author = get_comment_author_link($comment);
                    if (empty($comment_author)) {
                        $comment_author = __('Anonymous', 'businesspro');
                    }
                    echo $comment_author;
                    ?>
                    
                    <?php if (user_can($comment->user_id, 'edit_posts')) : ?>
                        <span class="comment-author-badge"><?php esc_html_e('Author', 'businesspro'); ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="comment-date">
                    <a href="<?php echo esc_url(get_comment_link($comment, $args)); ?>">
                        <time datetime="<?php comment_time('c'); ?>">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <polyline points="12,6 12,12 16,14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <?php
                            /* translators: 1: comment date, 2: comment time */
                            printf(__('%1$s at %2$s', 'businesspro'), get_comment_date(), get_comment_time());
                            ?>
                        </time>
                    </a>
                    
                    <?php edit_comment_link(__('Edit', 'businesspro'), '<span class="edit-link">', '</span>'); ?>
                </div>
            </div>
        </div>

        <div class="comment-content">
            <?php if ('0' == $comment->comment_approved) : ?>
                <div class="comment-awaiting-moderation">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="12" y1="8" x2="12" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <line x1="12" y1="16" x2="12.01" y2="16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <?php esc_html_e('Your comment is awaiting moderation.', 'businesspro'); ?>
                </div>
            <?php endif; ?>

            <div class="comment-text">
                <?php comment_text(); ?>
            </div>
        </div>

        <div class="comment-actions">
            <?php
            comment_reply_link(array_merge($args, array(
                'add_below' => $add_below,
                'depth'     => $depth,
                'max_depth' => $args['max_depth'],
                'before'    => '<div class="reply-link">',
                'after'     => '</div>',
                'reply_text' => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9 17l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M20 18v-2a4 4 0 0 0-4-4H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> ' . __('Reply', 'businesspro'),
            )));
            ?>
        </div>

        <?php if ('div' != $args['style']) : ?>
            </div>
        <?php endif; ?>
        <?php
    }
endif;
?>
