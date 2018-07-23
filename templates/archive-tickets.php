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

			<table id="archive-tickets">
				<thead>
					<tr>
						<th class="ticket-title">Title</th>
						<th class="ticket-name">Name</th>
						<th class="ticket-building">Building</th>
						<th class="ticket-unit">Unit</th>
						<th class="ticket-importance">Importance</th>
						<th class="ticket-status">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php while( $tickets->have_posts() ) : $tickets->the_post(); ?>
					<tr class="ticket">

						<td class="ticket-title">
							<?php the_title( sprintf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' ); ?>
						</td>
						<td class="ticket-name"> 
							<?php echo get_avatar( get_custom_field( 'your-email'),  32 ) . ' ';
							$name = get_post_meta($post->ID, 'your-name', true ); echo $name ;?>
						</td>
						<td class="ticket-building"> 
							<?php $name = get_post_meta($post->ID, 'building', true ); echo $name ;?>
						</td>
						<td class="ticket-unit"> 
							<?php $name = get_post_meta($post->ID, 'unit', true ); echo $name ;?>
						</td>
						<td class="ticket-importance"> 
							<?php $name = get_post_meta($post->ID, 'importance', true ); echo $name ;?>
						</td>
						<td class="ticket-status">
							<?php 
								$name = get_post_meta($post->ID, 'status', true ); 
								if( $name == 1){ echo "Resolved"; }else{ echo "Open"; }
							?>
						</td>
					</tr>
		       		<?php endwhile; endif; wp_reset_postdata(); ?>
	       	 	</tbody>
	        </table>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<!--<?php //get_sidebar(); ?>-->

<?php get_footer(); ?>