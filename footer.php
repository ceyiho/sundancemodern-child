<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Sundance Modern
 * @since Sundance Modern 1.0
 */
?>

	</div><!-- #main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php do_action( 'sundance_credits' ); ?>
			<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'sundance' ); ?>" rel="generator"><?php printf( __( 'Powered by %s', 'sundance' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( '%1$s by %2$s', 'sundance' ), 'Sundance Modern', '<a href="https://github.com/ceyiho" rel="designer">ceyiho</a>' ); ?>
            <span class="sep"> | </span>
            <?php printf( __( 'A child theme of %1$s.', 'sundance' ), '<a href="http://wordpress.org/extend/themes/sundance/" rel="designer">Sundance</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- .site-footer .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>