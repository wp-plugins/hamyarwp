<?php

	/*
		Plugin Name: hamyarWP
		Plugin URI: https://wordpress.org/plugins/hamyarWP/
		Description: ابزارک نمایش جدیدترین ارسال‌های همیار وردپرس ...
		Version: 1.0
		Author: Nima Saberi
		Author URI: http://ideyeno.ir/
	*/
	
	function hamyar_feed() 
	{
		$html = '<div class="rss-widget">';
		$widget_options = hamyarwp_widgetoptions();
		wp_widget_rss_output(array(
			'url' => 'http://hamyarwp.com/feed/',
			'title' => 'آخرین اخبار و مطالب همیار وردپرس',
			'meta' => array( 'target' => '_blank' ),
			'items' => $widget_options['posts_number'],
			'show_summary' => 0, 
			'show_author' => 0, 
			'show_date' => 1 
		));
		$html .= '<div style="border-top: 1px solid #e7e7e7; padding-top: 12px !important; font-size: 12px;">';
		$html .= '<img src="' . plugins_url( 'logo.png' , __FILE__ ) . '" style="width: 20px;height: 20px;margin: 0 0px 0 10px;float: right;" /> ';
		$html .= '<a href="http://hamyarwp.com/" target="_blank"><b>همیار وردپرس</b> ؛ اکسیژن وردپرسی‌ها</a>';
		$html .= '</div>';
		$html .= '</div>';
		echo $html;
	}
	
	function hamyarwp_widgetoptions() 
	{	
		$defaults = array( 
			'posts_number' => 5 
		);
		$options = get_option( 'hamyarwp_feed' );
		if ( ! $options || ! is_array($options) ) {
			$options = array();
		}
		return array_merge( $defaults, $options );
	}
	
	function hamyarwp_widset() 
	{
		$options = hamyarwp_widgetoptions();
		if ( 'post' == strtolower($_SERVER['REQUEST_METHOD']) && isset( $_POST['widget_id'] ) && 'hamyarwp_feed' == strip_tags($_POST['widget_id']) ) {
			foreach ( array( 'posts_number' ) as $key ) {
				$options[$key] = strip_tags($_POST[$key]);
			}
			update_option( 'hamyarwp_feed', $options );
		}
		$html = '<p>';
		$html .= '<label for="posts_number">تعداد نوشته‌های همیار وردپرس :</label><br>';
		$html .= '<select id="posts_number" name="posts_number" style="width: 200px;margin-top: 10px;">';
		$html .= "<option value='3'" . ( $options['posts_number'] == 3 ? " selected='selected'" : '' ) . ">3</option>";
		$html .= "<option value='5'" . ( $options['posts_number'] == 5 ? " selected='selected'" : '' ) . ">5</option>";
		$html .= "<option value='7'" . ( $options['posts_number'] == 7 ? " selected='selected'" : '' ) . ">7</option>";
		$html .= "<option value='10'" . ( $options['posts_number'] == 10 ? " selected='selected'" : '' ) . ">10</option>";
		$html .= '</select>';
		$html .= '</p>';
		echo $html;
	}
	
	function add_dashboard_widgets()	
	{
		wp_add_dashboard_widget('hamyarwp_feed', 'آخرین اخبار همیار وردپرس', 'hamyar_feed', 'hamyarwp_widset');
	}
	add_action('wp_dashboard_setup', 'add_dashboard_widgets');
	
	function hamyarwp_footer() {
		return "نیرو گرفته از وردپرس، به کمک <a href='http://hamyarwp.com/' target='_blank'>همیار وردپرس</a>";
	}
	add_filter('admin_footer_text', 'hamyarwp_footer');
	
	function remove_menu()
	{
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('wp-logo');
		$wp_admin_bar->remove_menu('about');
		$wp_admin_bar->remove_menu('wporg');
		$wp_admin_bar->remove_menu('documentation');
		$wp_admin_bar->remove_menu('support-forums');
		$wp_admin_bar->remove_menu('feedback');
		//$wp_admin_bar->remove_menu('view-site');
	}
	add_action('wp_before_admin_bar_render', 'remove_menu');
	
	function hamyarwp_menu()
	{
		global $wp_admin_bar;
		if( is_super_admin() || is_admin_bar_showing() )
		{
			$wp_admin_bar->add_menu(array(
				'id'		=>	'hamyarwp',
				'title'		=>	'<img src="'.plugin_dir_url(__FILE__).'/logo.png" style="width: 18px;height: 18px;margin: 7px 5px 0 5px;" />',
				'href'		=>	'http://hamyarwp.com/',
				'target'		=>	'_blank',
			));
		} else {
			return false;
		}
	}
	
	if ( is_admin() ) 
	{
		add_action('admin_bar_menu', 'hamyarwp_menu');
	}

?>