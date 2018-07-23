<?php 
/**
 * Template Name: Single Ticket
 *
 */
 get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
    <div class="row">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header><!-- .entry-header -->
				<div class="entry-content">
					<?php
						the_content();

						wp_link_pages(
							array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
								'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
								'separator'   => '<span class="screen-reader-text">, </span>',
							)
						);

						if ( '' !== get_the_author_meta( 'description' ) ) {
							get_template_part( 'template-parts/biography' );
						}

					?>
				<div class="custom-meta">
					<p>
					<?php
						echo get_avatar( get_custom_field( 'your-email' ) ). '<br>';
						echo get_the_date() . ' ' . get_the_time() . '<br>';
						echo 'Name: ' . get_custom_field( 'your-name' ) . '<br>';
						echo 'Email: ' . get_custom_field( 'your-email' ) . '<br>';
						echo 'Department: ' . get_custom_field( 'department' ) . '<br>';
						echo 'Importance: ' . get_custom_field( 'importance' ) . '<br>';
						echo 'Building Number: ' . get_custom_field( 'building' ) . '<br>';
						echo 'Unit Number: ' . get_custom_field( 'unit' );

					?>
					</p>
				</div>
				</div><!-- .entry-content -->

				<footer class="entry-footer">
					<?php
						edit_post_link(
							sprintf(
								/* translators: %s: Name of current post */
								__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
								get_the_title()
							),
							'<span class="edit-link">',
							'</span>'
						);
					?>
				</footer><!-- .entry-footer -->
			</article><!-- #post-## -->
			<?php
		// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// End of the loop.
		endwhile;
		?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>