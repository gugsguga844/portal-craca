<?php
/**
 * The header for our theme
 *
 * @package Portal_Craca
 */

$cat_colors = portal_get_category_colors();
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text"
			href="#primary"><?php esc_html_e('Skip to content', 'portal-craca'); ?></a>

		<!-- Donate Bar -->
		<div class="donate-bar">
			<a href="#" class="flex items-center justify-center gap-2">
				<span class="text-lg">🔥</span>
				<span>Apoie o jornalismo independente — <strong class="underline">Doe agora</strong></span>
				<span class="text-lg">🔥</span>
			</a>
		</div>

		<header id="masthead" class="sticky top-0 z-50 bg-craca-dark/95 backdrop-blur-md border-b border-craca-cream/10">
			<!-- Main Header Area -->
			<div class="section-container py-4 flex justify-between items-center">

				<!-- Logo -->
				<div class="site-branding flex items-center gap-3">
					<a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-3 group">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-icon.png"
							 alt="<?php bloginfo('name'); ?>"
							 class="w-10 h-10 md:w-12 md:h-12 transition-transform duration-300 group-hover:rotate-12">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-text-light.png"
							 alt="Portal Garganta"
							 class="h-8 md:h-10 hidden sm:block">
					</a>
				</div>

				<!-- Desktop Navigation -->
				<nav class="hidden lg:flex items-center gap-1">
					<?php
					$nav_categories = array(
						'documentarios'  => 'Documentários',
						'cidade'         => 'Cidade',
						'entretenimento' => 'Entretenimento',
						'esportes'       => 'Esportes',
						'denuncia'       => 'Denúncia',
						'coisas'         => 'Coisas',
						'politica'       => 'Política',
					);

					foreach ( $nav_categories as $slug => $label ) :
						$cat = get_category_by_slug( $slug );
						$link = $cat ? get_category_link( $cat->term_id ) : '#';
						$color = isset( $cat_colors[ $slug ] ) ? $cat_colors[ $slug ]['color'] : '#ff6625';
					?>
						<a href="<?php echo esc_url( $link ); ?>"
						   class="relative text-sm font-squidboy uppercase tracking-wider text-craca-cream/80
								  hover:text-craca-cream px-3 py-2 transition-colors duration-300 group">
							<?php echo esc_html( $label ); ?>
							<span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 group-hover:w-3/4
									     transition-all duration-300 rounded-full"
								  style="background-color: <?php echo esc_attr( $color ); ?>"></span>
						</a>
					<?php endforeach; ?>
				</nav>

				<!-- Mobile Menu Button -->
				<button id="mobile-menu-toggle"
						class="lg:hidden flex flex-col justify-center items-center w-10 h-10 gap-1.5 group"
						aria-label="Menu" aria-expanded="false">
					<span class="block w-6 h-0.5 bg-craca-cream transition-all duration-300 origin-center group-[.is-active]:rotate-45 group-[.is-active]:translate-y-2"></span>
					<span class="block w-6 h-0.5 bg-craca-cream transition-all duration-300 group-[.is-active]:opacity-0"></span>
					<span class="block w-6 h-0.5 bg-craca-cream transition-all duration-300 origin-center group-[.is-active]:-rotate-45 group-[.is-active]:-translate-y-2"></span>
				</button>
			</div>

			<!-- 3. Mobile Menu Drawer -->
			<div id="mobile-menu"
				 class="lg:hidden fixed inset-0 top-[var(--header-height,72px)] bg-craca-dark/98 backdrop-blur-lg
						z-40 transform translate-x-full transition-transform duration-300 ease-out overflow-y-auto"
				 aria-hidden="true">
				<nav class="flex flex-col p-8 gap-2">
					<?php foreach ( $nav_categories as $slug => $label ) :
						$cat = get_category_by_slug( $slug );
						$link = $cat ? get_category_link( $cat->term_id ) : '#';
						$color = isset( $cat_colors[ $slug ] ) ? $cat_colors[ $slug ]['color'] : '#ff6625';
					?>
						<a href="<?php echo esc_url( $link ); ?>"
						   class="font-squidboy text-2xl uppercase tracking-wider py-3 border-b border-craca-cream/10
								  hover:pl-4 transition-all duration-300"
						   style="color: <?php echo esc_attr( $color ); ?>">
							<?php echo esc_html( $label ); ?>
						</a>
					<?php endforeach; ?>

					<a href="#"
					   class="mt-6 donate-bar rounded-sm text-center">
						🔥 Apoie o Portal Garganta
					</a>
				</nav>
			</div>
		</header><!-- #masthead -->