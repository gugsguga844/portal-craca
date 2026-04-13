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

<body <?php body_class('bg-craca-dark text-craca-cream'); ?>>
	<?php wp_body_open(); ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text"
			href="#primary"><?php esc_html_e('Skip to content', 'portal-craca'); ?></a>

		<header id="masthead" class="sticky top-0 z-50 bg-craca-dark/95 backdrop-blur-md border-b border-craca-cream/10">

			<!-- 1. Top Utility Bar -->
			<div class="bg-craca-green text-craca-cream/70 text-xs py-1.5 hidden md:block">
				<div class="section-container flex justify-between items-center">
					<div class="font-body">
						<?php echo date_i18n('l, j \d\e F \d\e Y'); ?>
					</div>
					<div class="flex items-center gap-4">
						<a href="#" class="hover:text-craca-orange transition-colors" aria-label="Instagram">
							<svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
						</a>
						<a href="#" class="hover:text-craca-orange transition-colors" aria-label="Twitter/X">
							<svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
						</a>
						<a href="#" class="hover:text-craca-orange transition-colors" aria-label="YouTube">
							<svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
						</a>
					</div>
				</div>
			</div>

			<!-- 2. Main Header Area -->
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