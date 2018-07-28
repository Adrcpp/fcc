<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _s
 */

?>

	   </div><!-- #content -->

	<footer id="colophon" class="footer container-fluid">

		<?php
			use Functionality\Footer_Builder;
			Footer_Builder::singleton();
			Footer_Builder::get_footer_content();
		?>

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
