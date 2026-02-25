<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
// A Custom function for get an option
if ( ! function_exists( 'bh_get_option' ) ) {
  function bh_get_option( $option = '', $default = null ) {
    $options = get_option( 'bh_preloader' ); // Attention: Set your unique id of the framework
    return ( isset( $options[$option] ) ) ? $options[$option] : $default;
  }
}



// Adding Preloader
function bh_custom_preloader_section(){ 

$preloader_opt = bh_get_option('bh-preloader-opt');
$preloader_homepage_opt = bh_get_option('bh-preloader-homepage-opt');
$preloader_type = bh_get_option('bh-preloader-type');
$image_preloaders = bh_get_option('bh-image-preloaders');
$css3_pre_style = bh_get_option('bh-preloader-pro-css3-style');


	if($preloader_opt == true){
		
		if($preloader_type == 'pre-1'){
			if($preloader_homepage_opt == true){
				if(is_front_page()){ ?>
				<!-- START PRELOADER -->
				<div class="preloader">
					<div class="status" style="background-image: url(<?php echo esc_url(BHPREDIRURI . 'img/'. $image_preloaders . '.gif');?>); background-position: center;  background-repeat: no-repeat;"></div>
				</div>
				<!-- END PRELOADER -->
				<?php }	?>
			<?php }else{ ?>
				<!-- START PRELOADER -->
				<div class="preloader">
					<div class="status" style="background-image: url(<?php echo esc_url(BHPREDIRURI . 'img/'. $image_preloaders . '.gif');?>); background-position: center;  background-repeat: no-repeat;"></div>
				</div>
				<!-- END PRELOADER -->
			<?php } ?>
	<?php  
		
	}else{ 
	if($preloader_homepage_opt == true){
			if(is_front_page()){ ?>
			<!-- START PRELOADER -->
			<div class="preloader">
				<div class="spinner">
					<div class="double-bounce1"></div>
					<div class="double-bounce2"></div>
				</div>
			</div>
			<!-- END PRELOADER -->			
		<?php } ?>
		
		<?php }else{?> 
		<!-- START PRELOADER -->
		<div class="preloader">
			<div class="spinner">
			<?php
			if($css3_pre_style == 'ppc-1'){
			?>
				<div class="double-bounce1"></div>
				<div class="double-bounce2"></div>
			<?php
			}elseif($css3_pre_style == 'ppc-2'){ ?>
				<div class="lds-dual-ring"></div>
			<?php }elseif($css3_pre_style == 'ppc-3'){ ?>
				<div class="lds-facebook"><div></div><div></div><div></div></div>
			<?php }elseif($css3_pre_style == 'ppc-4'){ ?>
				<div class="lds-ring"><div></div><div></div><div></div><div></div></div>
			<?php }elseif($css3_pre_style == 'ppc-5'){ ?>
				<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
			<?php }elseif($css3_pre_style == 'ppc-6'){ ?>
				<div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
			<?php }elseif($css3_pre_style == 'ppc-7'){ ?>
				<div class="lds-ripple"><div></div><div></div></div>
			<?php }elseif($css3_pre_style == 'ppc-8'){ ?>
				<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
			<?php } ?>
			</div>
		</div>
		<!-- END PRELOADER -->	
		<?php }
	
		}
	}
}
add_action('wp_footer' , 'bh_custom_preloader_section');

// Adding Preloader options css
function bh_custom_preloader_option_css(){
	$preloader_bg_color = bh_get_option('bh-preloader-bg-color');
	$preloader_opacity = bh_get_option('bh-opacity');
	$preloader_color = bh_get_option('bh-preloader-color');
	
	?>

	<style type="text/css">
		.preloader{
			background-color: <?php echo esc_attr($preloader_bg_color); ?>;
			opacity: <?php echo esc_attr($preloader_opacity); ?>;
		}
		.double-bounce1, 
		.double-bounce2 {
			background-color:<?php echo esc_attr($preloader_color); ?>;
		}
		.double-bounce1, 
		.double-bounce2,
		.lds-facebook div,
		.lds-roller div:after,
		.lds-default div,
		.lds-spinner div:after{
			background-color:<?php echo esc_attr($preloader_color); ?>;
		}
		.lds-dual-ring:after {
			border: 5px solid <?php echo esc_attr($preloader_color); ?>;
			border-color: <?php echo esc_attr($preloader_color); ?> transparent <?php echo esc_attr($preloader_color); ?> transparent;
		}
		.lds-ring div{
			border: 6px solid <?php echo esc_attr($preloader_color); ?>;
			border-color: <?php echo esc_attr($preloader_color); ?> transparent transparent transparent;
		}
		.lds-ripple div {
			 border: 4px solid <?php echo esc_attr($preloader_color); ?>;
		}		
	</style>
<?php	
}
add_action('wp_head' , 'bh_custom_preloader_option_css');

// Adding Preloader Active jQuery
function bhcustom_preloader_js(){ 
$preloader_delay_time = bh_get_option('bh-delay-time');
?>

	<script type="text/javascript">

			/*PRELOADER JS*/
			jQuery(window).on('load', function() {  
				jQuery('.spinner').fadeOut();
				jQuery('.preloader').delay(<?php echo esc_js($preloader_delay_time);?>).fadeOut('slow'); 
			}); 
			/*END PRELOADER JS*/	
			
	</script>

<?php	
}
add_action('wp_footer' , 'bhcustom_preloader_js');

