<?php
/**
 * Template Name: Tickets Archive
 *Tamplate Post: 
 */

get_header(); ?>

<?php
$args = array(
  'post_type'   => 'tickets',
  'post_status' => 'publish',
 );
$tickets = new WP_Query( $args );
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php if( $tickets->have_posts() ) : ?>

			<header class="page-header">
				<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
			</header><!-- .page-header -->

			<?php while( $tickets->have_posts() ) : $tickets->the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				</header><!-- .entry-header -->
				<div class="entry-content"><?php the_excerpt(); echo get_post_meta( get_the_ID(), 'your-name', true ); ?></div>
	        </article>

	        <?php endwhile; endif; wp_reset_postdata(); ?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>