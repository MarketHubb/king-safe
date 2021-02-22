<div class="custom-template">

    <?php
    if (get_field('page_include_banner')) {
        get_template_part('template-parts/posts/content', 'hero');
    } else {
        get_template_part('template-parts/posts/content', 'legacy');
    }
    ?>

    <div class="container-fluid">
        <div class="wrapper">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <?php
                    the_content(sprintf(
                    /* translators: %s: Name of current post. */
                        wp_kses(__('Continue reading %s <span class="meta-nav">&rarr;</span>', 'locks'), array('span' => array('class' => array()))),
                        the_title('<span class="screen-reader-text">"', '"</span>', false)
                    ));

                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'locks'),
                        'after' => '</div>',
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>