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
		 1. DONATE BAR
		 ============================================ -->
	<section id="donate-bar" class="donate-bar">
		<a href="#" class="flex items-center justify-center gap-2">
			<span class="text-lg">🔥</span>
			<span>Apoie o jornalismo independente — <strong class="underline">Doe agora</strong></span>
			<span class="text-lg">🔥</span>
		</a>
	</section>

	<!-- ============================================
		 2. HERO — DESTAQUE PRINCIPAL
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

	// Fallback: if no ACF tag, just grab the latest sticky or latest post
	if ( ! $hero_query->have_posts() ) {
		$hero_args = array(
			'post_type'      => 'post',
			'posts_per_page' => 1,
		);
		$hero_query = new WP_Query( $hero_args );
	}

	if ( $hero_query->have_posts() ) :
		while ( $hero_query->have_posts() ) :
			$hero_query->the_post();
			$displayed_posts[] = get_the_ID();
			$is_urgente        = function_exists('get_field') ? get_field('is_urgente') : false;
			$creditos_imagem   = function_exists('get_field') ? get_field('creditos_imagem') : '';
			$cat_class         = portal_get_post_cat_class();
	?>
	<section class="py-6 md:py-10">
		<div class="section-container">
			<article id="post-<?php the_ID(); ?>" <?php post_class('hero-article group'); ?>>
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="block w-full h-full absolute inset-0">
						<?php the_post_thumbnail('hero-large', array('class' => 'object-cover w-full h-full transition-transform duration-700 group-hover:scale-105')); ?>
						<div class="absolute inset-0 bg-gradient-to-t from-craca-dark via-craca-dark/50 to-transparent"></div>
					</a>
				<?php endif; ?>

				<div class="absolute bottom-0 left-0 w-full p-6 md:p-10 z-10">
					<?php if ( $is_urgente ) : ?>
						<div class="mb-4 inline-block">
							<span class="animate-pulse bg-cat-denuncia text-white text-sm font-squidboy-bold uppercase tracking-widest px-4 py-1.5 rounded-sm">
								🚨 Urgente
							</span>
						</div>
					<?php endif; ?>

					<div class="mb-3">
						<span class="cat-badge cat-badge--<?php echo esc_attr( $cat_class ); ?>">
							<?php
							$categories = get_the_category();
							if ( ! empty( $categories ) ) {
								echo esc_html( $categories[0]->name );
							}
							?>
						</span>
					</div>

					<a href="<?php echo esc_url( get_permalink() ); ?>" class="block">
						<h2 class="font-squidboy-bold text-3xl md:text-5xl lg:text-6xl leading-tight mb-4
								   text-craca-cream hover:text-craca-orange transition-colors duration-300 text-shadow-dark">
							<?php the_title(); ?>
						</h2>
					</a>

					<div class="flex items-center text-sm md:text-base text-craca-cream/70 gap-3 font-body">
						<span class="font-medium">Por <?php the_author(); ?></span>
						<span class="text-craca-orange">•</span>
						<span><?php echo get_the_date(); ?></span>
					</div>

					<?php if ( $creditos_imagem ) : ?>
						<span class="block mt-2 text-xs text-craca-cream/40 italic">Foto: <?php echo esc_html( $creditos_imagem ); ?></span>
					<?php endif; ?>
				</div>
			</article>
		</div>
	</section>
	<?php
		endwhile;
		wp_reset_postdata();
	endif;
	?>

	<!-- ============================================
		 3. ÚLTIMAS NOTÍCIAS (8 latest)
		 ============================================ -->
	<?php
	$latest_args = array(
		'post_type'      => 'post',
		'posts_per_page' => 8,
		'post__not_in'   => ! empty( $displayed_posts ) ? $displayed_posts : array( 0 ),
	);
	$latest_query = new WP_Query( $latest_args );

	if ( $latest_query->have_posts() ) :
	?>
	<section class="py-10 md:py-16 border-t-2 border-craca-dark/10">
		<div class="section-container">
			<h2 class="font-squidboy-bold text-3xl md:text-4xl uppercase tracking-wider text-craca-orange mb-8
					   pl-4 border-l-4 border-craca-orange">
				Últimas Notícias
			</h2>

			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
				<?php
				while ( $latest_query->have_posts() ) :
					$latest_query->the_post();
					$displayed_posts[] = get_the_ID();
					$cat_class = portal_get_post_cat_class();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('news-card group'); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="news-card__img">
							<?php the_post_thumbnail('card-medium'); ?>
						</a>
					<?php endif; ?>

					<div class="news-card__body">
						<span class="cat-badge cat-badge--<?php echo esc_attr( $cat_class ); ?> mb-2 self-start text-[10px]">
							<?php
							$categories = get_the_category();
							if ( ! empty( $categories ) ) {
								echo esc_html( $categories[0]->name );
							}
							?>
						</span>

						<a href="<?php echo esc_url( get_permalink() ); ?>" class="block flex-grow">
							<h3 class="news-card__title line-clamp-3">
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
		wp_reset_postdata();
	endif;
	?>

	<!-- ============================================
		 4. PATROCINADORES
		 ============================================ -->
	<section class="relative py-10 md:py-14 bg-craca-green border-y-2 border-craca-dark text-craca-cream overflow-hidden">
		<div class="texture-overlay opacity-30"></div>
		<div class="section-container relative z-10">
			<h2 class="font-squidboy text-center text-xl uppercase tracking-[0.3em] text-craca-cream/50 mb-8">
				Patrocinadores
			</h2>

			<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6 items-center justify-items-center">
				<?php for ( $i = 1; $i <= 6; $i++ ) : ?>
					<div class="w-full max-w-[140px] h-16 rounded border border-dashed border-craca-cream/20
								flex items-center justify-center text-craca-cream/20 text-xs font-body uppercase tracking-wider
								hover:border-craca-orange/40 hover:text-craca-orange/40 transition-colors duration-300">
						Sponsor <?php echo $i; ?>
					</div>
				<?php endfor; ?>
			</div>
		</div>
	</section>

	<!-- ============================================
		 5. CATEGORY SECTIONS
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
	<section class="py-10 md:py-14 border-t-2 border-craca-dark/10">
		<div class="section-container">
			<div class="flex items-end justify-between mb-8">
				<h2 class="cat-heading cat-heading--<?php echo esc_attr( $slug ); ?>">
					<?php echo esc_html( $label ); ?>
				</h2>
				<a href="<?php echo esc_url( get_category_link( $cat_obj->term_id ) ); ?>"
				   class="hidden md:inline-block text-sm font-squidboy uppercase tracking-wider
						  text-craca-dark/50 hover:text-craca-orange border-b border-craca-dark/20
						  hover:border-craca-orange pb-1 transition-all duration-300">
					Ver mais →
				</a>
			</div>

			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
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
						<span class="cat-badge cat-badge--<?php echo esc_attr( $slug ); ?> mb-2 self-start text-[10px]">
							<?php echo esc_html( $label ); ?>
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

			<!-- Mobile "Ver mais" link -->
			<div class="mt-6 text-center md:hidden">
				<a href="<?php echo esc_url( get_category_link( $cat_obj->term_id ) ); ?>"
				   class="btn-cta text-craca-cream/70">
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

	<!-- ============================================
		 6. TORNE-SE UMA FONTE
		 ============================================ -->
	<section class="relative py-16 md:py-24 bg-craca-cream overflow-hidden border-t-2 border-craca-dark/10">
		<!-- Texture overlay -->
		<div class="texture-overlay"></div>

		<div class="section-container relative z-20 text-center">
			<div class="max-w-3xl mx-auto">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-mouth.png"
					 alt="Portal Garganta"
					 class="w-20 h-20 mx-auto mb-6 opacity-60">

				<h2 class="font-squidboy-bold text-4xl md:text-6xl uppercase tracking-wider text-craca-orange mb-6">
					Torne-se uma Fonte
				</h2>

				<p class="font-body text-lg md:text-xl text-craca-dark/80 leading-relaxed mb-8">
					Tem uma denúncia, pauta ou informação que precisa ser contada?
					O Portal Garganta é feito de vozes que não se calam.
					<br class="hidden md:block">
					Envie sua contribuição de forma segura e anônima.
				</p>

				<div class="bg-white border-2 border-craca-dark shadow-[6px_6px_0_0_#15230d] rounded-md p-6 md:p-8 inline-block">
					<p class="font-squidboy text-sm uppercase tracking-[0.3em] text-craca-dark/60 mb-3">
						Envie para
					</p>
					<a href="mailto:contato@portalgarganta.com.br"
					   class="font-squidboy-bold text-2xl md:text-3xl text-craca-orange hover:text-craca-pink transition-colors duration-300 break-all">
						contato@portalgarganta.com.br
					</a>
				</div>

				<p class="mt-6 text-sm text-craca-dark/50 font-body text-center">
					Sua identidade será preservada. Jornalismo é serviço público.
				</p>
			</div>
		</div>
	</section>

</main>

<?php
get_footer();
?>
