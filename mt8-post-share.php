<?php
/*
	Plugin Name: MT8 Post Share
	Plugin URI: https://github.com/mt8/mt8-post-share
	Description: Show SNS button on the post page.
	Author: mt8.biz
	Version: 0.1
	Author URI: http://mt8.biz
	Domain Path: /languages
	Text Domain: mt8-post-share
*/	

	$mt8_ps = new Mt8_Post_Share();
	$mt8_ps->register_hooks();

	class Mt8_Post_Share {

		const TEXT_DOMAIN = 'mt8-post-share';
		
		public function __construct() {
			
		}

		public function register_hooks() {
			
			add_action( 'plugins_loaded', array( &$this, 'plugins_loaded' ) );
			add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
			add_action( 'admin_print_styles-post.php', array( &$this, 'admin_print_styles_post_php' ) );
			
		}
		
		
		public function plugins_loaded() {
			
			load_plugin_textdomain( self::TEXT_DOMAIN, false, dirname( plugin_basename( __FILE__ ) ).'/languages' );
			
		}
		
		public function admin_menu() {
			
			add_meta_box( 'mt8_post_share', __( 'Share with SNS.', self::TEXT_DOMAIN ), array( &$this, 'mt8_post_share_inside' ), 'post', 'side', 'high' );
			
		}
		
		public function admin_print_styles_post_php() {

			if ( ! $this->_can_share() ) {
				return;
			}
			
			wp_enqueue_style( 'mt8_ps_style', plugins_url().'/'.dirname( plugin_basename( __FILE__ ) ).'/assets/css/style.css' );
			
		}
		
		public function mt8_post_share_inside() {
			
			$this->_output_sns_share();
			
		}
		
		private function _can_share() {

			global $post;
			return ( $post && 'publish' == $post->post_status );
			
		}
		
		private function _output_sns_share() { ?>
			<div class="mt8_ps_wrap">
			<?php if ( $this->_can_share() ) : ?>
				<?php
					global $post;
					$this->_out_put_facebook( $post );
					$this->_out_put_twitter( $post );
				?>
			<?php else : ?>
				<p><?php _e( 'Button appears when you publish the post.', self::TEXT_DOMAIN ) ?></p>
			<?php endif; ?>
			</div>
			<?php
		}
		
		private function _out_put_facebook( $post ) {
			?>
			<div class="mt8_ps_fb">
				<a target="_blank" class="mt8_ps_sns" href="http://www.facebook.com/sharer.php?src=bm&u=<?php echo esc_attr( urlencode( get_the_permalink( $post->ID ) ) ) ?>"><?php _e( 'Facebook', self::TEXT_DOMAIN ) ?></a>
			</div>
			<?php
		}
		
		private function _out_put_twitter( $post ) {
			?>
			<div class="mt8_ps_tw">
				<a target="_blank" class="mt8_ps_sns" href="https://twitter.com/intent/tweet?url=<?php echo esc_attr( urlencode( get_the_permalink( $post->ID ) ) ) ?>"><?php _e( 'Twitter', self::TEXT_DOMAIN ) ?></a>
			</div>
			<?php
			
		}
		
	}

