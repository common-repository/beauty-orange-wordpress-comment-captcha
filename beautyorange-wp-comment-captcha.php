<?php
/*
Plugin Name: Beauty Orange WordPress Comment Captcha
Plugin URI: http://www.beautyorange.com/beauty-orange-projects/beauty-orange-wordpress-comment-captcha/
Description: A plugin for WordPress, simple comment captcha.
Author: leo
Version: 1.00
Author URI: http://www.beautyorange.com
*/

function captcha_comment_form($post_id) {
	if(!current_user_can('level_1')){
		$beautyorange_wp_comment_captcha_a=rand(3,5);
		$beautyorange_wp_comment_captcha_b=rand(0,9);
		echo "<p><label>Captcha </label><span>*</span><input type=text name=beautyorange_wp_comment_captcha_value id=beautyorange_wp_comment_captcha_value /><br />= ".$beautyorange_wp_comment_captcha_a." + ".$beautyorange_wp_comment_captcha_b."<input name=beautyorange_wp_comment_captcha_a value=".$beautyorange_wp_comment_captcha_a." type=hidden />"."<input name=beautyorange_wp_comment_captcha_b value=".$beautyorange_wp_comment_captcha_b." type=hidden /></p>";
	}
}

function captcha_comment_post($commentdata) {
	// Ignore trackbacks and bypass captcha for logged in users (except 'subscriber')
	if($commentdata['comment_type']!='trackback' && !current_user_can('level_1')) {
		$beautyorange_wp_comment_captcha_a = trim($_POST[beautyorange_wp_comment_captcha_a]);
		$beautyorange_wp_comment_captcha_b = trim($_POST[beautyorange_wp_comment_captcha_b]);
		$beautyorange_wp_comment_captcha_value = trim($_POST[beautyorange_wp_comment_captcha_value]);
		if((($beautyorange_wp_comment_captcha_a+$beautyorange_wp_comment_captcha_b)!=$beautyorange_wp_comment_captcha_value)
			||empty($beautyorange_wp_comment_captcha_value)){
			wp_die('Error: Please input Captcha！');
		}
	}
	return $commentdata;
}

// add Captcha to the comment form
add_action('comment_form', 'captcha_comment_form', 10);
// verify Captcha
add_action('preprocess_comment', 'captcha_comment_post');
?>
