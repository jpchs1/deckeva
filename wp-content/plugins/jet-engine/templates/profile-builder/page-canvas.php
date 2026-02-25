<?php
/**
 * The Template for displaying profile page
 */

defined( 'ABSPATH' ) || exit;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if ( ! current_theme_supports( 'title-tag' ) ) : ?>
		<title><?php echo wp_get_document_title(); ?></title>
	<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<?php
	/**
	 * Hook before main page content output.
	 * Add template wrappers start on this hook
	 */
	do_action( 'jet-engine/profile-builder/template/before-main-content' );

	/**
	 * Hoor to display main page content
	 */
	do_action( 'jet-engine/profile-builder/template/main-content' );

	/**
	 * Hook before main page content output.
	 * Add template wrappers start on this hook
	 */
	do_action( 'jet-engine/profile-builder/template/after-main-content' );

	wp_footer();

	?>
	</body>
</html>
