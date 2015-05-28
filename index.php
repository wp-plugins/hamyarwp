<?php

	/*
		Plugin Name: hamyarWP
		Plugin URI: https://wordpress.org/plugins/hamyarWP/
		Description: ابزارک نمایش جدیدترین ارسال‌های همیار وردپرس ...
		Version: 0.1
		Author: Nima Saberi
		Author URI: http://ideyeno.ir/
		
	*/
	
	function hamyarwp_feed()
	{
		require_once (ABSPATH . WPINC . '/rss.php');
		$rss = @fetch_rss('http://hamyarwp.com/feed/');
		if ( isset($rss->items) && count($rss->items) != 0 )
		{
			$rss->items = array_slice($rss->items, 0, 10);
			echo "<ul>";
			foreach ($rss->items as $item )
			{
				echo "<li><a href='".wp_filter_kses($item['link'])."' target='_blank'>".wp_specialchars($item['title'])."</a></li>";
			}
			echo "</ul>";
		}
	}
	
	function add_dashboard_widgets()
	{
		wp_add_dashboard_widget('dashboard_widget', 'آخرین اخبار همیار وردپرس', 'hamyarwp_feed');
	}
	
	add_action('wp_dashboard_setup', 'add_dashboard_widgets');

?>