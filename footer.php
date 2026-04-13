<?php
/**
 * The template for displaying the footer
 *
 * @package Portal_Craca
 */

$cat_colors = portal_get_category_colors();
$nav_categories = array(
	'documentarios'  => 'Documentários',
	'cidade'         => 'Cidade',
	'entretenimento' => 'Entretenimento',
	'esportes'       => 'Esportes',
	'denuncia'       => 'Denúncia',
	'coisas'         => 'Coisas',
	'politica'       => 'Política',
);
?>

	<footer id="colophon" class="site-footer relative bg-craca-green text-craca-cream border-t border-craca-dark/10 overflow-hidden">
		<!-- Subtle texture -->
		<div class="texture-overlay opacity-5"></div>

		<div class="section-container relative z-10 py-12 md:py-16">
			<div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-16">

				<!-- Column 1: Brand -->
				<div class="flex flex-col">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center gap-3 mb-6 group">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-icon.png"
							 alt="Portal Garganta"
							 class="w-12 h-12 transition-transform duration-300 group-hover:rotate-12">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-text-light.png"
							 alt="Portal Garganta"
							 class="h-10">
					</a>
					<p class="text-sm text-craca-cream/60 font-body leading-relaxed mb-6">
						Jornalismo independente, livre de amarras políticas.
						Descentralizando a informação, rejuvenescendo a notícia.
					</p>
					<div class="flex items-center gap-4">
						<a href="#" class="text-craca-cream/40 hover:text-craca-orange transition-colors" aria-label="Instagram">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
						</a>
						<a href="#" class="text-craca-cream/40 hover:text-craca-orange transition-colors" aria-label="Twitter/X">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
						</a>
						<a href="#" class="text-craca-cream/40 hover:text-craca-orange transition-colors" aria-label="YouTube">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
						</a>
					</div>
				</div>

				<!-- Column 2: Categories -->
				<div>
					<h3 class="font-squidboy-bold text-lg uppercase tracking-wider text-craca-cream mb-6">Editorias</h3>
					<nav class="flex flex-col gap-2">
						<?php foreach ( $nav_categories as $slug => $label ) :
							$cat = get_category_by_slug( $slug );
							$link = $cat ? get_category_link( $cat->term_id ) : '#';
							$color = isset( $cat_colors[ $slug ] ) ? $cat_colors[ $slug ]['color'] : '#ff6625';
						?>
							<a href="<?php echo esc_url( $link ); ?>"
							   class="text-sm font-body text-craca-cream/50 hover:text-craca-cream transition-colors duration-300 flex items-center gap-2">
								<span class="w-2 h-2 rounded-full flex-shrink-0" style="background-color: <?php echo esc_attr( $color ); ?>"></span>
								<?php echo esc_html( $label ); ?>
							</a>
						<?php endforeach; ?>
					</nav>
				</div>

				<!-- Column 3: Participate -->
				<div>
					<h3 class="font-squidboy-bold text-lg uppercase tracking-wider text-craca-cream mb-6">Participe</h3>
					<ul class="flex flex-col gap-3 text-sm font-body text-craca-cream/50">
						<li>
							<a href="#" class="hover:text-craca-orange transition-colors">🔥 Apoie / Doe</a>
						</li>
						<li>
							<a href="mailto:contato@portalgarganta.com.br" class="hover:text-craca-orange transition-colors">
								📧 Torne-se uma fonte
							</a>
						</li>
						<li>
							<a href="#" class="hover:text-craca-orange transition-colors">📋 Anuncie conosco</a>
						</li>
					</ul>

					<div class="mt-6 p-4 bg-craca-dark/50 rounded border border-craca-cream/10">
						<p class="font-squidboy text-xs uppercase tracking-widest text-craca-cream/40 mb-1">Contato</p>
						<a href="mailto:contato@portalgarganta.com.br"
						   class="text-sm font-body text-craca-orange hover:text-craca-pink transition-colors break-all">
							contato@portalgarganta.com.br
						</a>
					</div>
				</div>
			</div>
		</div>

		<!-- Bottom bar -->
		<div class="border-t border-craca-cream/10 py-4">
			<div class="section-container flex flex-col md:flex-row justify-between items-center gap-3 text-xs text-craca-cream/30 font-body">
				<p>&copy; <?php echo date('Y'); ?> Portal Garganta. Jornalismo independente.</p>
				<p>Feito com 🧡 na garganta do povo.</p>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
