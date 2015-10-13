<?php

namespace Beck24\FlexibleFriendlyTime;

const PLUGIN_ID = 'flexible_friendlytime';

elgg_register_event_handler('init', 'system', __NAMESPACE__ . '\\init');

/**
 *  Init
 */
function init() {
	elgg_register_plugin_hook_handler('format', 'friendly:time', __NAMESPACE__ . '\\format_friendlytime');
}

/**
 * Format the friendly time
 * 
 * @param type $hook
 * @param type $type
 * @param type $return
 * @param type $params
 * @return type
 */
function format_friendlytime($hook, $type, $return, $params) {

	$language = get_current_language();

	// get our language dependent settings
	$format1 = elgg_get_plugin_setting('format1' . $language, PLUGIN_ID);
	$format1override = elgg_get_plugin_setting('format1override' . $language, PLUGIN_ID);
	$format2 = elgg_get_plugin_setting('format2' . $language, PLUGIN_ID);
	$format2override = elgg_get_plugin_setting('format2override' . $language, PLUGIN_ID);
	$breaktime = (int) elgg_get_plugin_setting('breaktime' . $language, PLUGIN_ID);
	$offset = (int) elgg_get_plugin_setting('offset' . $language, PLUGIN_ID);

	// use regular time for elgg default, modtime otherwise
	$time = $params['time'];
	$modtime = $time + (60 * 60 * $offset);

	$format = 1;
	if (!empty($breaktime) && ($params['time'] < (time() - 60 * 60 * $breaktime))) {
		$format = 2;
	}

	if ($format == 1) {
		if (empty($format1override)) {
			$check = $format1;
		} else {
			return translate_friendlytime($format1override, $modtime);
		}
	}

	if ($format == 2) {
		if (empty($format2override)) {
			$check = $format2;
		} else {
			return translate_friendlytime($format2override, $modtime);
		}
	}

	// nothing set, keep as elgg default
	if (empty($check)) {
		$check = 1;
	}

	switch ($check) {
		case 1:
			// default, leave $return alone
			break;
		case 2:
			$return = elgg_echo('flexible_friendlytime:format:1', array(translate_friendlytime('M j, Y', $modtime), translate_friendlytime('g:ia', $modtime)));
			break;
		default:
			$return = translate_friendlytime($check, $modtime);
			break;
	}

	return $return;
}


/**
 * makes dates translatable to current language
 * 
 * @param type $dateformat
 * @param type $time
 * @return type
 */
function translate_friendlytime($dateformat, $time = NULL) {
	if (empty($time) && $time !== 0) {
		$time = time();
	}

	$output = "";
	for ($i = 0; $i < strlen($dateformat); $i++) {
		$j = $i - 1;

		if ($dateformat[$j] == "\\") {
			$output .= $dateformat[$i];
			continue;
		}

		if ($dateformat[$i] == "\\" && $dateformat[$j] != "\\") {
			$output .= "";
			continue;
		}

		if ($dateformat[$i] == " ") {
			$output .= " ";
			continue;
		}

		if ($dateformat[$i] == "D" && $dateformat[$j] != "\\") {
			$output .= elgg_echo('flexible_friendlytime:shortday:' . date("D", $time));
			continue;
		}

		if ($dateformat[$i] == "l" && $dateformat[$j] != "\\") {
			$output .= elgg_echo('flexible_friendlytime:longday:' . date("l", $time));
			continue;
		}

		if ($dateformat[$i] == "F" && $dateformat[$j] != "\\") {
			$output .= elgg_echo('flexible_friendlytime:longmonth:' . date("F", $time));
			continue;
		}

		if ($dateformat[$i] == "M" && $dateformat[$j] != "\\") {
			$output .= elgg_echo('flexible_friendlytime:shortmonth:' . date("M", $time));
			continue;
		}

		if (strtolower($dateformat[$i]) == "a" && $dateformat[$j] != "\\") {
			$output .= elgg_echo('flexible_friendlytime:' . date($dateformat[$i], $time));
			continue;
		}

		$output .= date($dateformat[$i], $time);
	}

	return $output;
}
