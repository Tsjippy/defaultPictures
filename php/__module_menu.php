<?php
namespace SIM\DEFAULTPICTURES;
use SIM;

const MODULE_VERSION		= '8.0.7';

DEFINE(__NAMESPACE__.'\MODULE_PATH', plugin_dir_path(__DIR__));

//module slug is the same as grandparent folder name
DEFINE(__NAMESPACE__.'\MODULE_SLUG', strtolower(basename(dirname(__DIR__))));

add_filter('sim_submenu_defaultpictures_options', __NAMESPACE__.'\subMenuOptions', 10, 2);
function subMenuOptions($optionsHtml, $settings){
	ob_start();

	//Get all post types
	$args = array(
		'public'   => true,
		'_builtin' => false
	 );
	$postTypes = array_merge(get_post_types( $args, 'names', 'and' ), ['post']);

	foreach($postTypes as $postType){
		if($postType == 'post'){
			$tax	= 'category';
		}else{
			$tax	= $postType.'type';
		}
		echo "<h3>Default pictures for {$postType}s</h3>";
		echo "<h4>Default picture for $postType</h4>";
		SIM\pictureSelector($postType, ucfirst($postType), $settings);
		echo "<h4>Default pictures per category for {$postType}s</h4>";
		$categories	= get_terms(['hide_empty' => false, 'taxonomy'=>$tax]);
		foreach($categories as $category){
			SIM\pictureSelector($category->slug, $category->name, $settings);
		}
		echo '<br><br>';
	}

	return $optionsHtml.ob_get_clean();
}