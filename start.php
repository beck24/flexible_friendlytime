<?php
/**
 * Author: Matt Beckett
 * Website: http://clever-name.com
 * 
 * License: GPL2
 */


function flexible_friendlytime_init() {
  elgg_register_plugin_hook_handler('format', 'friendly:time', 'flexible_friendlytime_hook_handler');
}



function flexible_friendlytime_hook_handler($hook, $type, $return, $params) {
  
  // make sure we have a language file for the selected language
  // otherwise default to english
  $languagepaths = elgg_get_file_list(elgg_get_plugins_path() . "flexible_friendlytime/languages/", array(), array(), array('.php'));
  $languages = array();
  foreach($languagepaths as $langpath){
    $languages[] = basename($langpath, '.php');
  }
  
  if(elgg_is_logged_in()){
    // logged in, use user language
    if(!in_array(elgg_get_logged_in_user_entity()->language, $languages)){
      $language = 'en';
    }
    else{
      $language = elgg_get_logged_in_user_entity()->language;
    }
  }
  else{
    // not logged in, use site language
    if(!in_array(elgg_get_config('language'), $languages)){
      $language = 'en';
    }
    else{
      $language = elgg_get_config('language');
    } 
  }
  
  // get our language dependent settings
  $format1 = elgg_get_plugin_setting('format1'.$language, 'flexible_friendlytime');
  $format1override = elgg_get_plugin_setting('format1override'.$language, 'flexible_friendlytime');
  $format2 = elgg_get_plugin_setting('format2'.$language, 'flexible_friendlytime');
  $format2override = elgg_get_plugin_setting('format2override'.$language, 'flexible_friendlytime');
  $breaktime = elgg_get_plugin_setting('breaktime'.$language, 'flexible_friendlytime');
  $offset = elgg_get_plugin_setting('offset'.$language, 'flexible_friendlytime');
  
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
      return flexible_friendlytime_translate($format1override, $modtime);
    }
  }
  
  if($format == 2){
    if(empty($format2override)){
      $check = $format2;
    }
    else{
      return flexible_friendlytime_translate($format2override, $modtime);
    }
  }
  
  // nothing set, keep as elgg default
  if(empty($check)){
    $check = 1;
  }
  
  switch ($check) {
    case 1:
      // default, leave $return alone
      break;
    case 2:
        $return = elgg_echo('flexible_friendlytime:format:1', array(flexible_friendlytime_translate('M j, Y', $modtime), flexible_friendlytime_translate('g:ia', $modtime)));
      break;
    default:
        $return = flexible_friendlytime_translate($check, $modtime);
      break;
  }
  
  return $return;
}

//
// This function makes dates translatable to current language
function flexible_friendlytime_translate($dateformat, $time = NULL){
  if(empty($time) && $time !== 0){
    $time = time();
  }
  
  $output = "";
  for($i=0; $i<strlen($dateformat); $i++){
    $j = $i - 1;
    
    if($dateformat[$j] == "\\"){
      $output .= $dateformat[$i];
      continue;
    }
    
    if($dateformat[$i] == "\\" && $dateformat[$j] != "\\"){
      $output .= "";
      continue;
    }
    
    if($dateformat[$i] == " "){
      $output .= " ";
      continue;
    }
    
    if($dateformat[$i] == "D" && $dateformat[$j] != "\\"){
      $output .= elgg_echo('flexible_friendlytime:shortday:' . date("D", $time));
      continue;
    }
    
    if($dateformat[$i] == "l" && $dateformat[$j] != "\\"){
      $output .= elgg_echo('flexible_friendlytime:longday:' . date("l", $time));
      continue;
    }
    
    if($dateformat[$i] == "F" && $dateformat[$j] != "\\"){
      $output .= elgg_echo('flexible_friendlytime:longmonth:' . date("F", $time));
      continue;
    }
    
    if($dateformat[$i] == "M" && $dateformat[$j] != "\\"){
      $output .= elgg_echo('flexible_friendlytime:shortmonth:' . date("M", $time));
      continue;
    }
    
    if(strtolower($dateformat[$i]) == "a" && $dateformat[$j] != "\\"){
      $output .= elgg_echo('flexible_friendlytime:' . date($dateformat[$i], $time));
      continue;
    }
    
    $output .= date($dateformat[$i], $time);
  }
  
  return $output;
}


elgg_register_event_handler('init', 'system', 'flexible_friendlytime_init');