<!DOCTYPE html>
<html <?php language_attributes(); ?> >

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
    <link rel="profile" href="//gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> >

	<?php
	    if ( function_exists( 'wp_body_open' ) ) {
	        wp_body_open();
	    }
    ?>

	<div class="wrap-fullwidth"><div class="inside-content">
	
<?php echo apply_filters( 'aovis_render_header', '' ); ?>