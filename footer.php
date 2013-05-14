<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Readly
 * @since Readly 1.0
 */
?>

	</div><!-- #main -->
</div><!-- #page -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<div id="footer-wrapper">
		<div class="site-info">
			<div id="site-info-wrapper">
				<div id="site-info-wrapper2">
					<?php do_action( 'readly_credits' ); ?>
					&#169; Copyright 2013 <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></a>. Powered By <a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'readly' ); ?>" rel="generator"><?php echo __( 'WordPress', 'readly' ); ?></a>.
					<br />
					Designed & Crafted by <a href="http://wpshower.com/">Wpshower</a>.
				</div>
			</div>
		</div><!-- .site-info -->
		<div id="social">
			<div id="social_wrapper">
				<div id="social_wrapper2">
<?php
$options = get_option('readly_social');
$array = array(
	'twitter' => 'w',
	'facebook' => 'f',
	'instagram' => 'h',
	'pinterest' => 'p',
	'dribbble' => 'd',
	'google' => 'g',
	'vimeo' => 'v',
	'flickr' => '8',
	'rss' => 'r'
);
foreach ($array as $key => $value):
	if ($options[$key] != ''):
?>
					<a href="<?php echo $options[$key]; ?>"><?php echo $value; ?></a>
<?php
	endif;
endforeach;
?>
				</div>
			</div>
		</div>
	</div>
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>