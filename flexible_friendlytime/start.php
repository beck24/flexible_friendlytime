<?php
/**
 * Author: Matt Beckett
 * Website: http://clever-name.com
 * 
 * License: GPL2
 */

elgg_register_event_handler('init', 'system', 'flexible_friendlytime_init');

function flexible_friendlytime_init() {
  elgg_register_plugin_hook_handler('format', 'friendly:time', 'flexible_friendlytime_hook_handler');
}

function flexible_friendlytime_hook_handler($hook, $type, $return, $params) {
  $format1 = elgg_get_plugin_setting('format1', 'flexible_friendlytime');
  $format1override = elgg_get_plugin_setting('format1override', 'flexible_friendlytime');
  $format2 = elgg_get_plugin_setting('format2', 'flexible_friendlytime');
  $format2override = elgg_get_plugin_setting('format2override', 'flexible_friendlytime');
  $breaktime = elgg_get_plugin_setting('breaktime', 'flexible_friendlytime');
  $offset = elgg_get_plugin_setting('offset', 'flexible_friendlytime');
  
  // use regular time for elgg default, modtime otherwise
  $time = $params['time'];
  $modtime = $time + (60*60*$offset);
  
  $format = 1;
  if(!empty($breaktime) && ($params['time'] < (time() - 60*60*$breaktime))){
    $format = 2;
  }

  if($format == 1){
    if(empty($format1override)){
      $check = $format1;
    }
    else{
      return date($format1override, $modtime);
    }
  }
  
  if($format == 2){
    if(empty($format2override)){
      $check = $format2;
    }
    else{
      return date($format2override, $modtime);
    }
  }
  
  
  switch ($check) {
    case 1:
      // default, leave $return alone
      break;
    case 2:
        $return = elgg_echo('flexible_friendlytime:format:1', array(date('M j, Y', $modtime), date('g:ia', $modtime)));
      break;
    default:
        $return = date($check, $modtime);
      break;
  }
  
  return $return;
}