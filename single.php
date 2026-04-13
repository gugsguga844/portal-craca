<?php
/**
 * The template for displaying all single posts — Portal Garganta
 *
 * @package Portal_Craca
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	while ( have_posts() ) :
		the_post();
		$is_urgente      = function_exists('get_field') ? get_field( 'is_urgente' ) : false;
		$creditos_imagem = function_exists('get_field') ? get_field( 'creditos_imagem' ) : '';
		$post_id         = get_the_ID();
		$cat_class       = portal_get_post_cat_class();
	?>

		<!-- 1. Article Header -->
		<header class="max-w-4xl mx-auto px-4 pt-10 pb-6">
			<?php if ( $is_urgente ) : ?>
				<div class="mb-6 inline-block">
					<span class="animate-pulse bg-cat-denuncia text-white text-sm font-squidboy-bold uppercase tracking-widest px-4 py-1.5 rounded-sm">
						🚨 Urgente
					</span>
				</div>
			<?php endif; ?>

			<div class="mb-4">
				<span class="cat-badge cat-badge--<?php echo esc_attr( $cat_class ); ?>">
					<?php
					$categories = get_the_category();
					if ( ! empty( $categories ) ) {
						echo esc_html( $categories[0]->name );
					}
					?>
				</span>
			</div>

			<h1 class="font-squidboy-bold text-3xl md:text-5xl lg:text-6xl leading-tight text-craca-dark mb-6">
				<?php the_title(); ?>
			</h1>

			<div class="flex items-center text-craca-dark/60 text-sm font-body gap-3 mb-8">
				<span class="font-medium">Por <?php the_author(); ?></span>
				<span class="text-craca-orange">•</span>
				<span><?php echo get_the_date(); ?></span>
			</div>
		</header>

		<!-- 2. Featured Image -->
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="max-w-4xl mx-auto px-4 mb-8">
				<div class="w-full rounded-md overflow-hidden mb-2 relative">
					<?php the_post_thumbnail( 'hero-large', array( 'class' => 'w-full h-auto object-cover' ) ); ?>
				</div>
				<?php
				$caption = get_the_post_thumbnail_caption();
				if ( $creditos_imagem || $caption ) :
				?>
					<div class="text-xs text-craca-dark/40 text-right italic font-body">
						<?php
						if ( $caption ) {
							echo esc_html( $caption );
						}
						if ( $caption && $creditos_imagem ) {
							echo ' | ';
						}
						if ( $creditos_imagem ) {
							echo 'Foto: ' . esc_html( $creditos_imagem );
						}
						?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<!-- 3. Article Body -->
		<div class="max-w-3xl mx-auto px-4 py-8">
			<div class="prose prose-lg md:prose-xl max-w-none
						prose-headings:font-squidboy-bold prose-headings:text-craca-dark
						prose-a:text-craca-orange prose-a:no-underline hover:prose-a:underline
						prose-strong:text-craca-dark prose-blockquote:border-craca-orange
						prose-blockquote:text-craca-dark/80 mx-auto font-body">
				<?php the_content(); ?>
			</div>
		</div>

		<!-- 4. Related Posts -->
		<?php
		$cats = wp_get_post_categories( $post_id );
		if ( $cats ) {
			$related_args  = array(
				'category__in'   => $cats,
				'post__not_in'   => array( $post_id ),
				'posts_per_page' => 3,
				'post_type'      => 'post',
				'orderby'        => 'date',
				'order'          => 'DESC',
			);
			$related_query = new WP_Query( $related_args );

			if ( $related_query->have_posts() ) :
			?>
			<section class="py-12 border-t-2 border-craca-dark/10 mt-12">
				<div class="max-w-5xl mx-auto px-4">
					<h2 class="font-squidboy-bold text-2xl uppercase tracking-wider text-craca-orange mb-8
							   pl-4 border-l-4 border-craca-orange">
						Leia também
					</h2>
					<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
						<?php
						while ( $related_query->have_posts() ) :
							$related_query->the_post();
							$rel_cat_class = portal_get_post_cat_class();
						?>
						<article class="news-card group">
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php echo esc_url( get_permalink() ); ?>" class="news-card__img">
									<?php the_post_thumbnail( 'card-medium' ); ?>
								</a>
							<?php endif; ?>

							<div class="news-card__body">
								<span class="cat-badge cat-badge--<?php echo esc_attr( $rel_cat_class ); ?> mb-2 self-start text-[10px]">
									<?php
									$related_categories = get_the_category();
									if ( ! empty( $related_categories ) ) {
										echo esc_html( $related_categories[0]->name );
									}
									?>
								</span>
								<a href="<?php echo esc_url( get_permalink() ); ?>" class="block flex-grow">
									<h3 class="news-card__title line-clamp-2">
										<?php the_title(); ?>
									</h3>
								</a>
								<div class="news-card__meta">
									<?php echo get_the_date(); ?>
								</div>
							</div>
						</article>
						<?php endwhile; ?>
					</div>
				</div>
			</section>
			<?php
			endif;
			wp_reset_postdata();
		}
		?>

	<?php endwhile; ?>
</main>

<?php
get_footer();
?>
