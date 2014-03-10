<?php

/*
  Plugin Name: Auto More Tag
  Plugin URI: https://github.com/toubsen/wp-auto-more-tag
  Description: Automatically add a More tag to your posts upon publication. No longer are you required to spend your time figuring out the perfect position for the more tag, you can now set a rule and this plugin will--to the best of it's abilities--add a proper more tag at or at the nearest non-destructive location.
  Author: Travis Weston, Tobias Vogel
  Author URI: https://github.com/anubisthejackle
  Version: 3.2.2
 */

if (!defined('TW_AUTO_MORE_TAG')) {

	class tw_auto_more_tag {

		private static $_instance;
		public $length;
		public $options;
		public $data;

		public function __construct() {
			global $wpdb;
			$this->_db = &$wpdb;
			self::$_instance = $this;
		}

		private static function doLog($message) {
			file_put_contents('./debug.log', $message, FILE_APPEND);
		}

		public static function addTag($data, $arr = array()) {
			global $post;
			$options = get_option('tw_auto_more_tag');

			if ($post->post_type != 'post' && $options['set_pages'] != true) {
				$data = str_replace('<!--more-->', '', $data);
				return $data;
			}
			$length = $options['quantity'];
			$breakOn = $options['break'];

			$moreTag = mb_strpos($data, '[amt_override]');

			if ($moreTag !== false && $options['ignore_man_tag'] != true) {

				return self::$_instance->manual($data);
			}

			if (mb_strlen(strip_tags($data)) <= 0)
				return $data;

			switch ($options['units']) {
				case 1:
					return self::$_instance->byCharacter($data, $length, $breakOn);
					break;

				case 2:
				default:
					return self::$_instance->byWord($data, $length, $breakOn);
					break;

				case 3:
					return self::$_instance->byPercent($data, $length, $breakOn);
					break;
			}
		}

		public function manual($data) {

			$data = str_replace('<!--more-->', '', $data);
			$data = str_replace('[amt_override]', '[amt_override]<!--more-->', $data);

			return $data;
		}

		public function byWord($data, $length, $breakOn) {

			$break = ($breakOn == 2) ? PHP_EOL : ' ';
			$data = str_replace('<!--more-->', '', $data);
			$stripped_data = strip_tags($data);

			$fullLength = mb_strlen($data);

			$strippedLocation = 0;
			$wordCount = 0;
			$insertSpot = $fullLength;
			for ($i = 0; $i < $fullLength; $i++) {
				if (mb_substr($stripped_data, $strippedLocation, 1) != mb_substr($data, $i, 1)) {
					continue;
				}

				if ($wordCount >= $length) {
					if (mb_substr($stripped_data, $strippedLocation, 1) == $break) {
						$insertSpot = $i;
						break;
					}
				}

				if (mb_substr($stripped_data, $strippedLocation, 1) == ' ') {
					$wordCount++;
				}

				$strippedLocation++;
			}

			$start = mb_substr($data, 0, $insertSpot);
			$end = mb_substr($data, $insertSpot);

			if (mb_strlen(trim($start)) > 0 && mb_strlen(trim($end)) > 0)
				$data = $start . '<!--more-->' . $end;

			return $data;
		}

		public function byCharacter($data, $length, $breakOn) {

			$break = ($breakOn == 2) ? PHP_EOL : ' ';
			$data = str_replace('<!--more-->', '', $data);
			$stripped_data = strip_tags($data);

			$fullLength = mb_strlen($data);

			$strippedLocation = 0;

			$insertSpot = $fullLength;
			for ($i = 0; $i < $fullLength; $i++) {
				if (mb_substr($stripped_data, $strippedLocation, 1) != mb_substr($data, $i, 1)) {
					continue;
				}

				if ($strippedLocation >= $length) {
					if (mb_substr($stripped_data, $strippedLocation, 1) == $break) {
						$insertSpot = $i;
						break;
					}
				}

				$strippedLocation++;
			}

			$start = mb_substr($data, 0, $insertSpot);
			$end = mb_substr($data, $insertSpot);

			if (mb_strlen(trim($start)) > 0 && mb_strlen(trim($end)) > 0)
				$data = $start . '<!--more-->' . $end;

			return $data;
		}

		public function byPercent($data, $length, $breakOn) {

			$debug = null;
			$break = ($breakOn === 2) ? PHP_EOL : ' ';
			$data = str_replace('<!--more-->', '', $data);
			/* Strip Tags, get length */
			$stripped_data = strip_tags($data);
			$lengthOfPost = mb_strlen($stripped_data);
			$fullLength = mb_strlen($data);

			/* Find location to insert */
			$insert_location = $lengthOfPost * ($length / 100);

			/* iterate through post, look for differences between stripped and unstripped. If found, continue */
			$strippedLocation = 0;

			$insertSpot = $fullLength;
			for ($i = 0; $i < $fullLength; $i++) {
				if (mb_substr($stripped_data, $strippedLocation, 1) != mb_substr($data, $i, 1)) {
					continue;
				}

				if ($strippedLocation >= $insert_location) {
					if (mb_substr($stripped_data, $strippedLocation, 1) == $break) {
						$insertSpot = $i;
						break;
					}
				}

				$strippedLocation++;
			}

			$start = mb_substr($data, 0, $insertSpot);
			$end = mb_substr($data, $insertSpot);

			if (mb_strlen(trim($start)) > 0 && mb_strlen(trim($end)) > 0)
				$data = $start . '<!--more-->' . $end;

			return $data;
		}

		public function initOptionsPage() {

			register_setting('tw_auto_more_tag', 'tw_auto_more_tag', array($this, 'validateOptions'));
		}

		public function validateOptions($input) {


			$start = $input;

			$input['messages'] = array(
				'errors' => array(),
				'notices' => array(),
				'warnings' => array()
			);
			$input['quantity'] = (isset($input['quantity']) && (int) $input['quantity'] > 0) ? ((int) $input['quantity']) : 0;

			if ($input['quantity'] != $start['quantity']) {
				$input['messages']['notices'][] = 'Quantity cannot be less than 0, and has been set to 0.';
			}

			$input['ignore_man_tag'] = (isset($input['ignore_man_tag']) && ((bool) $input['ignore_man_tag'] == true)) ? true : false;

			$input['units'] = ((int) $input['units'] == 1) ? 1 : (((int) $input['units'] == 2) ? 2 : 3);

			if ($input['units'] == 3 && $input['quantity'] > 100) {
				$input['messages']['notices'][] = 'While using Percentage breaking, you cannot us a number larger than 100%. This field has been reset to 50%.';
				$input['quantity'] = 50;
			}

			$input['break'] = (isset($input['break']) && (int) $input['break'] == 2) ? 2 : 1;

			return $input;
		}

		public function buildOptionsPage() {
			require_once('auto-more-options-page.php');
		}

		public function addPage() {

			$this->option_page = add_options_page('Auto More Tag', 'Auto More Tag', 'manage_options', 'tw_auto_more_tag', array($this, 'buildOptionsPage'));
		}

		private function updateAll() {

			$posts = get_posts(array(
				'numberposts' => '-1',
				'post_status' => 'publish',
				'post_type' => 'post'
			));

			if (count($posts) > 0) {
				global $post;
				foreach ($posts as $post) {
					setup_postdata($post);
					$post->post_content = self::addTag($post->post_content);
					wp_update_post($post);
				}
			}
		}

		public function manualOverride($atts, $content = null, $code = null) {
			// We just want to make this tag disappear. Let's just make it go away now...
			return null;
		}

	}

	$tw_auto_more_tag = new tw_auto_more_tag();

	add_action('admin_init', array($tw_auto_more_tag, 'initOptionsPage'));
	add_action('admin_menu', array($tw_auto_more_tag, 'addPage'));
	add_filter('content_save_pre', 'tw_auto_more_tag::addTag', '1', 2);
	add_shortcode('amt_override', array($tw_auto_more_tag, 'manualOverride'));

	define('TW_AUTO_MORE_TAG', true);
}
