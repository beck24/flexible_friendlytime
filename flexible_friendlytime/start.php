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
  global $CONFIG;
  
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
    if(!in_array($CONFIG->language, $languages)){
      $language = 'en';
    }
    else{
      $language = $CONFIG->language;
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
function flexible_friendlytime_translate($dateformat, $time){
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
      $output .= flexible_friendlytime_translate_short_day(date("D", $time));
      continue;
    }
    
    if($dateformat[$i] == "l" && $dateformat[$j] != "\\"){
      $output .= flexible_friendlytime_translate_long_day(date("l", $time));
      continue;
    }
    
    if($dateformat[$i] == "F" && $dateformat[$j] != "\\"){
      $output .= flexible_friendlytime_translate_long_month(date("F", $time));
      continue;
    }
    
    if($dateformat[$i] == "M" && $dateformat[$j] != "\\"){
      $output .= flexible_friendlytime_translate_short_month(date("M", $time));
      continue;
    }
    
    if(strtolower($dateformat[$i]) == "a" && $dateformat[$j] != "\\"){
      $output .= flexible_friendlytime_translate_ampm(date($dateformat[$i], $time));
      continue;
    }
    
    $output .= date($dateformat[$i], $time);
  }
  
  return $output;
}

// translates longform month
function flexible_friendlytime_translate_long_month($month){
  switch ($month){
    case "January":
        return elgg_echo('flexible_friendlytime:january');
      break;
    case "February":
        return elgg_echo('flexible_friendlytime:february');
      break;
    case "March":
        return elgg_echo('flexible_friendlytime:march');
      break;
    case "April":
        return elgg_echo('flexible_friendlytime:april');
      break;
    case "May":
        return elgg_echo('flexible_friendlytime:maylong');
      break;
    case "June":
        return elgg_echo('flexible_friendlytime:june');
      break;
    case "July":
        return elgg_echo('flexible_friendlytime:july');
      break;
    case "August":
        return elgg_echo('flexible_friendlytime:august');
      break;
    case "September":
        return elgg_echo('flexible_friendlytime:september');
      break;
    case "October":
        return elgg_echo('flexible_friendlytime:october');
      break;
    case "November":
        return elgg_echo('flexible_friendlytime:november');
      break;
    case "December":
        return elgg_echo('flexible_friendlytime:december');
      break;
  }
}

// translates short month format
function flexible_friendlytime_translate_short_month($month){
  switch ($month){
    case "Jan":
      return elgg_echo('flexible_friendlytime:jan');
      break;
    case "Feb":
      return elgg_echo('flexible_friendlytime:feb');
      break;
    case "Mar":
      return elgg_echo('flexible_friendlytime:mar');
      break;
    case "Apr":
      return elgg_echo('flexible_friendlytime:apr');
      break;
    case "May":
      return elgg_echo('flexible_friendlytime:mayshort');
      break;
    case "Jun":
      return elgg_echo('flexible_friendlytime:jun');
      break;
    case "Jul":
      return elgg_echo('flexible_friendlytime:jul');
      break;
    case "Aug":
      return elgg_echo('flexible_friendlytime:aug');
      break;
    case "Sep":
      return elgg_echo('flexible_friendlytime:sep');
      break;
    case "Oct":
      return elgg_echo('flexible_friendlytime:oct');
      break;
    case "Nov":
      return elgg_echo('flexible_friendlytime:nov');
      break;
    case "Dec":
      return elgg_echo('flexible_friendlytime:dec');
      break;  
  }
}

// translates long form days
function flexible_friendlytime_translate_long_day($day){
  switch ($day){
    case "Monday":
      return elgg_echo('flexible_friendlytime:monday');
      break;
    case "Tuesday":
      return elgg_echo('flexible_friendlytime:tuesday');
      break;
    case "Wednesday":
      return elgg_echo('flexible_friendlytime:wednesday');
      break;
    case "Thursday":
      return elgg_echo('flexible_friendlytime:thursday');
      break;
    case "Friday":
      return elgg_echo('flexible_friendlytime:friday');
      break;
    case "Saturday":
      return elgg_echo('flexible_friendlytime:saturday');
      break;
    case "Sunday":
      return elgg_echo('flexible_friendlytime:sunday');
      break;
  }
}

// translates short form days
function flexible_friendlytime_translate_short_day($day){
  switch ($day){
    case "Mon":
      return elgg_echo('flexible_friendlytime:mon');
      break;
    case "Tue":
      return elgg_echo('flexible_friendlytime:tue');
      break;
    case "Wed":
      return elgg_echo('flexible_friendlytime:wed');
      break;
    case "Thu":
      return elgg_echo('flexible_friendlytime:thu');
      break;
    case "Fri":
      return elgg_echo('flexible_friendlytime:fri');
      break;
    case "Sat":
      return elgg_echo('flexible_friendlytime:sat');
      break;
    case "Sun":
      return elgg_echo('flexible_friendlytime:sun');
      break;
  }
}


function flexible_friendlytime_translate_ampm($ampm){
  switch ($ampm){
    case "am":
      return elgg_echo('flexible_friendlytime:am');
      break;
    case "AM":
      return elgg_echo('flexible_friendlytime:AM');
      break;
    case "pm":
      return elgg_echo('flexible_friendlytime:pm');
      break;
    case "PM":
      return elgg_echo('flexible_friendlytime:PM');
      break;
  }
}