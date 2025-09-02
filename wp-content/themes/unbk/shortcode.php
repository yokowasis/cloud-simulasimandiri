<?php
	function listening( $atts, $content = null ) {
	    $a = shortcode_atts( array(
	    ), $atts );
	    ob_start();
	    //Do Something
	    ?>
	        <?php //echo "foo = {$a['foo']}"; ?>
	        <?php //echo $content; ?>
	        <?php include ('listening.php'); ?>        
	    <?php
	    return ob_get_clean();
	}
	add_shortcode( 'listening', 'listening' );

	function video( $atts, $content = null ) {
	    $a = shortcode_atts( array(
	        'foo' => 'something',
	        'bar' => 'something else',
	    ), $atts );
	    ob_start();
	    //Do Something
	    ?>
	        <?php //echo "foo = {$a['foo']}"; ?>
	        <?php //echo $content; ?>
	        <?php include ('video.php'); ?>        
	    <?php
	    return ob_get_clean();
	}
	add_shortcode( 'video', 'video' );

	function embedcontent( $atts, $content = null ) {
	    $a = shortcode_atts( array(
	        'foo' => 'something',
	        'bar' => 'something else',
	    ), $atts );
	    ob_start();
	    //Do Something
	    ?>
	        <?php //echo "foo = {$a['foo']}"; ?>
	        <?php //echo $content; ?>
	        <?php include ('embedcontent.php'); ?>        
	    <?php
	    return ob_get_clean();
	}
	add_shortcode( 'embedcontent', 'embedcontent' );

	include ('extendedoption.php');
