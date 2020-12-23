<section id="safes">
    <div class="container-skew">
        <div class="container-straight">
            <div class="container-fixed">
                <?php if ( function_exists('yoast_breadcrumb') ) {
                    yoast_breadcrumb('<p id="breadcrumbs">','</p>');
                }
                the_content(); ?>
                <h2><?php the_field( 'safe_page_title' ); ?></h2>
                <div class="services-list">
                    <ul>
                        <li>Licensed, bonded, and insured locksmiths</li>
                        <li>Trouble-free safe moving</li>
                        <li>Safe service and repair</li>
                    </ul>
                    <ul>
                        <li>Combination changes for safes</li>
                        <li>Safe installation, including bolting</li>
                    </ul>
                </div>
                <?php get_template_part( 'template-parts/content', 'safes-list'); ?>
            </div>
        </div>
    </div>
</section>