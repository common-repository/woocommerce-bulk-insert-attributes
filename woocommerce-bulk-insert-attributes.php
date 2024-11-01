<?php
/*
Plugin Name: Woocommerce Bulk Insert Attributes
Plugin URI: http://www.advancedstyle.com/
Description: Insert a text list of multiple attributes at once
Author: David Barnes
Version: 1.0
Author URI: http://www.advancedstyle.com/
*/


function woo_bia_form($taxonomy){
	if(isset($_GET['post_type']) && $_GET['post_type'] == 'product'){
		echo '</form>';
		
		echo '<form action="'.$_SERVER['REQUEST_URI'].'" method="post">';
		echo '<h2>Bulk Insert</h2>';
		echo '<p>Each option should be on a separate line</p>';
		echo '<p><textarea name="woobiabulktags" rows="5" cols="40"></textarea></p>';
		echo '<p><input type="submit" value="Insert Terms" class="button-primary"></p>';
	}
}

add_action('add_tag_form','woo_bia_form', 99, 1);

function woo_bia_catch(){
	if(isset($_POST['woobiabulktags']) && trim($_POST['woobiabulktags']) != ''){
		$lines = explode("\n",$_POST['woobiabulktags']);
		foreach($lines as $line){
			$line = trim($line);
			if($line != ''){
				if(!term_exists($line, $_GET['taxonomy'])){
					wp_insert_term($line, $_GET['taxonomy']);
				}
			}
		}
		wp_redirect($_SERVER['REQUEST_URI']);
		exit();
	}
}

add_action('admin_init','woo_bia_catch');
?>