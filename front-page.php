<?php
/**
 * The front page template file — Portal Garganta
 *
 * @package Portal_Craca
 */

get_header();

$displayed_posts = array();
$cat_colors = portal_get_category_colors();
?>

<main id="primary" class="site-main">

	<!-- ============================================
		 1. HERO — DESTAQUE PRINCIPAL + SIDEBAR
		 ============================================ -->
	<?php
	$hero_args = array(
		'post_type'      => 'post',
		'posts_per_page' => 1,
		'meta_query'     => array(
			array(
				'key'   => 'estilo_home',
				'value' => 'destaque_principal',
			),
		),
	);
	$hero_query = new WP_Query( $hero_args );

	// Fallback: if no ACF tag, just grab the latest post
	if ( ! $hero_query->have_posts() ) {
		$hero_args = array(
			'post_type'      => 'post',
			'posts_per_page' => 1,
		);
		$hero_query = new WP_Query( $hero_args );
	}

	// Prepare sidebar: 2 secondary highlights
	$secondary_args = array(
		'post_type'      => 'post',
		'posts_per_page' => 2,
		'meta_query'     => array(
			array(
				'key'   => 'estilo_home',
				'value' => 'destaque_secundario',
			),
		),
	);
	$secondary_query = new WP_Query( $secondary_args );

	// Fallback: grab the 2nd and 3rd latest posts
	if ( ! $secondary_query->have_posts() ) {
		$secondary_args = array(
			'post_type'      => 'post',
			'posts_per_page' => 2,
			'offset'         => 1,
		);
		$secondary_query = new WP_Query( $secondary_args );
	}

	$secondary_posts = array();
	if ( $secondary_query->have_posts() ) {
		while ( $secondary_query->have_posts() ) {
			$secondary_query->the_post();
			$cats = get_the_category();
			$_slug = ! empty( $cats ) ? $cats[0]->slug : '';
			$secondary_posts[] = array(
				'id'        => get_the_ID(),
				'title'     => get_the_title(),
				'permalink' => get_permalink(),
				'date'      => get_the_date(),
				'author'    => get_the_author(),
				'excerpt'   => get_the_excerpt(),
				'thumbnail' => get_the_post_thumbnail( get_the_ID(), 'card-medium', array( 'class' => 'w-full h-full object-cover' ) ),
				'cat_name'  => ! empty( $cats ) ? $cats[0]->name : '',
				'cat_color' => isset( $cat_colors[ $_slug ]['color'] ) ? $cat_colors[ $_slug ]['color'] : '#ff6625',
				'cat_text'  => isset( $cat_colors[ $_slug ]['text'] ) ? $cat_colors[ $_slug ]['text'] : '#ffffff',
			);
			$displayed_posts[] = get_the_ID();
		}
		wp_reset_postdata();
	}

	if ( $hero_query->have_posts() ) :
		while ( $hero_query->have_posts() ) :
			$hero_query->the_post();
			$displayed_posts[] = get_the_ID();
			$is_urgente        = function_exists('get_field') ? get_field('is_urgente') : false;
			$creditos_imagem   = function_exists('get_field') ? get_field('creditos_imagem') : '';
			$cat_class         = portal_get_post_cat_class();
	?>
	<section class="py-8 md:py-12 bg-craca-green">
		<div class="section-container">
			<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

				<!-- LEFT: Notícia Principal (2/3) -->
				<div class="lg:col-span-2">
					<article id="post-<?php the_ID(); ?>" <?php post_class('group'); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php echo esc_url( get_permalink() ); ?>" class="block overflow-hidden rounded-md mb-4">
								<?php the_post_thumbnail('hero-large', array('class' => 'w-full h-auto object-cover rounded-md')); ?>
							</a>
							<?php if ( $creditos_imagem ) : ?>
								<p class="text-xs text-craca-cream/30 italic -mt-2 mb-4 text-right font-body">Foto: <?php echo esc_html( $creditos_imagem ); ?></p>
							<?php endif; ?>
						<?php endif; ?>

						<div class="flex items-center gap-2 mb-3">
							<?php
							$categories = get_the_category();
							$_hero_slug = ! empty( $categories ) ? $categories[0]->slug : '';
							$_hero_bg   = isset( $cat_colors[ $_hero_slug ]['color'] ) ? $cat_colors[ $_hero_slug ]['color'] : '#ff6625';
							$_hero_text = isset( $cat_colors[ $_hero_slug ]['text'] ) ? $cat_colors[ $_hero_slug ]['text'] : '#ffffff';
							?>
							<span class="cat-badge"
								  style="background-color: <?php echo esc_attr( $_hero_bg ); ?>; color: <?php echo esc_attr( $_hero_text ); ?>">
								<?php
								if ( ! empty( $categories ) ) {
									echo esc_html( $categories[0]->name );
								}
								?>
							</span>
							<?php if ( $is_urgente ) : ?>
								<span class="animate-pulse bg-cat-denuncia text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-sm">
									🚨 Urgente
								</span>
							<?php endif; ?>
						</div>

						<a href="<?php echo esc_url( get_permalink() ); ?>" class="block">
							<h2 class="font-extrabold text-2xl md:text-3xl lg:text-4xl leading-tight mb-4
									   text-craca-cream hover:text-craca-orange transition-colors duration-300">
								<?php the_title(); ?>
							</h2>
						</a>

						<p class="text-base md:text-lg text-craca-cream/70 leading-relaxed mb-4 font-body line-clamp-3">
							<?php echo get_the_excerpt(); ?>
						</p>

						<div class="flex items-center text-sm text-craca-cream/50 gap-3 font-body">
							<span class="font-medium text-craca-cream/70">Por <?php the_author(); ?></span>
							<span class="text-craca-orange">•</span>
							<span><?php echo get_the_date(); ?></span>
						</div>
					</article>
				</div>

				<!-- RIGHT: Destaques Secundários (1/3) -->
				<aside class="lg:col-span-1 flex flex-col gap-6">
					<?php foreach ( $secondary_posts as $sp ) : ?>
						<article class="group flex flex-col">
							<?php if ( $sp['thumbnail'] ) : ?>
								<a href="<?php echo esc_url( $sp['permalink'] ); ?>"
								   class="block overflow-hidden rounded-md mb-3 aspect-video">
									<?php echo $sp['thumbnail']; ?>
								</a>
							<?php endif; ?>

							<span class="cat-badge mb-2 self-start text-[10px]"
								  style="background-color: <?php echo esc_attr( $sp['cat_color'] ); ?>; color: <?php echo esc_attr( $sp['cat_text'] ); ?>">
								<?php echo esc_html( $sp['cat_name'] ); ?>
							</span>

							<a href="<?php echo esc_url( $sp['permalink'] ); ?>" class="block">
								<h3 class="font-bold text-base md:text-lg leading-snug text-craca-cream
										   hover:text-craca-orange transition-colors duration-200 line-clamp-2 mb-2">
									<?php echo esc_html( $sp['title'] ); ?>
								</h3>
							</a>


							<div class="text-[11px] text-craca-cream/40 font-body mt-auto">
								<span>Por <?php echo esc_html( $sp['author'] ); ?></span>
								<span class="mx-1">•</span>
								<span><?php echo esc_html( $sp['date'] ); ?></span>
							</div>
						</article>
					<?php endforeach; ?>
				</aside>

			</div><!-- /grid -->
		</div>
	</section>
	<?php
		endwhile;
		wp_reset_postdata();
	endif;
	?>

	<!-- ============================================
		 2. ÚLTIMAS NOTÍCIAS (8 latest — editorial layout)
		 ============================================ -->
	<?php
	$latest_args = array(
		'post_type'      => 'post',
		'posts_per_page' => 8,
		'post__not_in'   => ! empty( $displayed_posts ) ? $displayed_posts : array( 0 ),
	);
	$latest_query = new WP_Query( $latest_args );

	if ( $latest_query->have_posts() ) :
		// Collect posts into array for editorial layout
		$latest_posts = array();
		while ( $latest_query->have_posts() ) :
			$latest_query->the_post();
			$displayed_posts[] = get_the_ID();
			$cats = get_the_category();
			$latest_posts[] = array(
				'id'        => get_the_ID(),
				'title'     => get_the_title(),
				'permalink' => get_permalink(),
				'date'      => get_the_date(),
				'author'    => get_the_author(),
				'excerpt'   => get_the_excerpt(),
				'thumb_lg'  => get_the_post_thumbnail( get_the_ID(), 'hero-large', array( 'class' => 'w-full h-full object-cover' ) ),
				'thumb_sm'  => get_the_post_thumbnail( get_the_ID(), 'card-medium', array( 'class' => 'w-full h-auto rounded-lg' ) ),
				'cat_class' => portal_get_post_cat_class(),
				'cat_name'  => ! empty( $cats ) ? $cats[0]->name : '',
				'cat_color' => '',
				'cat_text'  => '',
			);
			// Fill in color data from map
			$_slug = ! empty( $cats ) ? $cats[0]->slug : '';
			if ( isset( $cat_colors[ $_slug ] ) ) {
				$latest_posts[ count($latest_posts) - 1 ]['cat_color'] = $cat_colors[ $_slug ]['color'];
				$latest_posts[ count($latest_posts) - 1 ]['cat_text']  = $cat_colors[ $_slug ]['text'];
			}
		endwhile;
		wp_reset_postdata();

		// Split into rows of 4 (1 featured + 3 side)
		$rows = array_chunk( $latest_posts, 4 );
	?>
	<section class="py-10 md:py-16 bg-craca-cream">
		<div class="section-container">
			<h2 class="text-2xl md:text-3xl font-extrabold uppercase tracking-wide text-craca-dark mb-8
					   pl-4 border-l-4 border-craca-orange">
				Últimas Notícias
			</h2>

			<?php foreach ( $rows as $row ) :
				if ( empty( $row ) ) continue;
				$featured = $row[0];
				$side_posts = array_slice( $row, 1 );
			?>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 last:mb-0">

				<!-- Left: Featured post (vertical card) -->
				<article class="news-card group">
					<?php if ( $featured['thumb_lg'] ) : ?>
						<a href="<?php echo esc_url( $featured['permalink'] ); ?>" class="news-card__img">
							<?php echo $featured['thumb_lg']; ?>
						</a>
					<?php endif; ?>

					<div class="news-card__body">
						<span class="cat-badge mb-2 self-start text-[10px]"
							  style="background-color: <?php echo esc_attr( $featured['cat_color'] ); ?>; color: <?php echo esc_attr( $featured['cat_text'] ); ?>">
							<?php echo esc_html( $featured['cat_name'] ); ?>
						</span>

						<a href="<?php echo esc_url( $featured['permalink'] ); ?>" class="block">
							<h3 class="news-card__title text-xl md:text-2xl line-clamp-3">
								<?php echo esc_html( $featured['title'] ); ?>
							</h3>
						</a>

						<p class="news-card__excerpt line-clamp-3">
							<?php echo $featured['excerpt']; ?>
						</p>

						<div class="news-card__meta">
							<span>Por <?php echo esc_html( $featured['author'] ); ?></span>
							<span class="mx-1">•</span>
							<span><?php echo esc_html( $featured['date'] ); ?></span>
						</div>
					</div>
				</article>

				<!-- Right: 3 stacked horizontal cards -->
				<div class="flex flex-col gap-0 divide-y divide-craca-dark/10">
					<?php foreach ( $side_posts as $sp ) : ?>
						<article class="flex gap-4 py-4 first:pt-0 last:pb-0 group">
							<?php if ( $sp['thumb_sm'] ) : ?>
								<a href="<?php echo esc_url( $sp['permalink'] ); ?>"
								   class="shrink-0 w-44 md:w-56 rounded-lg overflow-hidden bg-craca-dark/5">
									<?php echo $sp['thumb_sm']; ?>
								</a>
							<?php endif; ?>

							<div class="flex flex-col justify-center min-w-0">
								<span class="cat-badge mb-1.5 self-start text-[9px]"
									  style="background-color: <?php echo esc_attr( $sp['cat_color'] ); ?>; color: <?php echo esc_attr( $sp['cat_text'] ); ?>">
									<?php echo esc_html( $sp['cat_name'] ); ?>
								</span>

								<a href="<?php echo esc_url( $sp['permalink'] ); ?>" class="block">
									<h3 class="font-bold text-sm md:text-base leading-snug text-craca-dark
											   group-hover:text-craca-orange transition-colors duration-200 line-clamp-2 mb-1">
										<?php echo esc_html( $sp['title'] ); ?>
									</h3>
								</a>

								<p class="text-xs text-craca-dark/60 font-body leading-relaxed line-clamp-2 mb-1">
									<?php echo $sp['excerpt']; ?>
								</p>

								<div class="text-[11px] text-craca-dark/50 font-body">
									<span>Por <?php echo esc_html( $sp['author'] ); ?></span>
									<span class="mx-1">•</span>
									<span><?php echo esc_html( $sp['date'] ); ?></span>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
				</div>

			</div>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
	endif;
	?>

	<!-- ============================================
		 3. PATROCINADORES
		 ============================================ -->
	<section class="py-10 md:py-14 bg-craca-cream">
		<div class="section-container">
			<h2 class="text-center text-sm uppercase tracking-[0.3em] text-craca-dark/40 mb-8 font-body">
				Patrocinadores
			</h2>

			<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 items-center justify-items-center">
				<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
					<div class="w-full max-w-[140px] h-16 rounded-lg bg-white/60
								flex items-center justify-center text-craca-dark/20 text-xs font-body uppercase tracking-wider
								border border-craca-dark/10">
						Logo <?php echo $i; ?>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</section>

		<!-- ============================================
		 5. TORNE-SE UMA FONTE
		 ============================================ -->
	<section class="relative py-16 md:py-24 bg-craca-green overflow-hidden">
		<!-- Texture overlay -->
		<div class="texture-overlay"></div>

		<div class="section-container relative z-20 text-center">
			<div class="max-w-3xl mx-auto">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-mouth.png"
					 alt="Portal Garganta"
					 class="w-20 h-20 mx-auto mb-6 opacity-40">

				<h2 class="font-squidboy-bold text-4xl md:text-6xl uppercase tracking-wider text-craca-orange mb-6">
					Torne-se uma Fonte
				</h2>

				<p class="font-body text-lg md:text-xl text-craca-cream/70 leading-relaxed mb-8">
					Tem uma denúncia, pauta ou informação que precisa ser contada?
					O Portal Garganta é feito de vozes que não se calam.
					<br class="hidden md:block">
					Envie sua contribuição de forma segura e anônima.
				</p>

				<div class="bg-craca-dark/30 border border-craca-cream/20 rounded-md p-6 md:p-8 inline-block">
					<p class="font-squidboy text-xs uppercase tracking-[0.3em] text-craca-cream/50 mb-3">
						Envie para
					</p>
					<a href="mailto:contato@portalgarganta.com.br"
					   class="font-body font-bold text-2xl md:text-3xl text-craca-orange hover:text-craca-pink transition-colors duration-300 break-all">
						contato@portalgarganta.com.br
					</a>
				</div>

				<p class="mt-6 text-sm text-craca-cream/40 font-body text-center">
					Sua identidade será preservada. Jornalismo é serviço público.
				</p>
			</div>
		</div>
	</section>

	<!-- ============================================
		 4. CATEGORY SECTIONS
		 ============================================ -->
	<?php
	$section_categories = array(
		'documentarios'  => 'Documentários',
		'cidade'         => 'Cidade',
		'entretenimento' => 'Entretenimento',
		'esportes'       => 'Esportes',
		'denuncia'       => 'Denúncia',
		'coisas'         => 'Coisas',
		'politica'       => 'Política',
	);

	foreach ( $section_categories as $slug => $label ) :
		$cat_obj = get_category_by_slug( $slug );
		if ( ! $cat_obj ) continue;

		$cat_query_args = array(
			'post_type'      => 'post',
			'posts_per_page' => 4,
			'cat'            => $cat_obj->term_id,
		);
		$cat_query = new WP_Query( $cat_query_args );

		if ( $cat_query->have_posts() ) :
	?>
	<section class="py-10 md:py-14 bg-craca-cream border-t border-craca-dark/10">
		<div class="section-container">
			<div class="flex items-end justify-between mb-8">
				<?php
				$border_color = isset( $cat_colors[ $slug ]['color'] ) ? $cat_colors[ $slug ]['color'] : '#ff6625';
				?>
				<h2 class="cat-heading text-craca-dark"
					style="border-left-color: <?php echo esc_attr( $border_color ); ?>">
					<?php echo esc_html( $label ); ?>
				</h2>
				<a href="<?php echo esc_url( get_category_link( $cat_obj->term_id ) ); ?>"
				   class="hidden md:inline-block text-sm font-medium uppercase tracking-wider
						  text-craca-dark/50 hover:text-craca-orange border-b border-craca-dark/20
						  hover:border-craca-orange pb-1 transition-all duration-300">
					Ver mais →
				</a>
			</div>

			<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
				<?php
				while ( $cat_query->have_posts() ) :
					$cat_query->the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('news-card group'); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="news-card__img">
							<?php the_post_thumbnail('card-medium'); ?>
						</a>
					<?php endif; ?>

					<div class="news-card__body">
						<?php
						$badge_bg   = isset( $cat_colors[ $slug ]['color'] ) ? $cat_colors[ $slug ]['color'] : '#ff6625';
						$badge_text = isset( $cat_colors[ $slug ]['text'] ) ? $cat_colors[ $slug ]['text'] : '#ffffff';
						?>
						<span class="cat-badge mb-2 self-start text-[10px]"
							  style="background-color: <?php echo esc_attr( $badge_bg ); ?>; color: <?php echo esc_attr( $badge_text ); ?>">
							<?php echo esc_html( $label ); ?>
						</span>

						<a href="<?php echo esc_url( get_permalink() ); ?>" class="block">
							<h3 class="news-card__title line-clamp-2">
								<?php the_title(); ?>
							</h3>
						</a>

						<p class="news-card__excerpt line-clamp-2">
							<?php echo get_the_excerpt(); ?>
						</p>

						<div class="news-card__meta">
							<span>Por <?php the_author(); ?></span>
							<span class="mx-1">•</span>
							<span><?php echo get_the_date(); ?></span>
						</div>
					</div>
				</article>
				<?php endwhile; ?>
			</div>

			<!-- Mobile "Ver mais" link -->
			<div class="mt-6 text-center md:hidden">
				<a href="<?php echo esc_url( get_category_link( $cat_obj->term_id ) ); ?>"
				   class="inline-block text-sm font-medium uppercase tracking-wider text-craca-dark/50
						  border-b border-craca-dark/20 pb-1">
					Ver mais de <?php echo esc_html( $label ); ?>
				</a>
			</div>
		</div>
	</section>
	<?php
		endif;
		wp_reset_postdata();
	endforeach;
	?>

</main>

<?php
get_footer();
?>
