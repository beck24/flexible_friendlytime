<?php
/**
 * Author: Matt Beckett
 * Website: http://clever-name.com
 * 
 * License: GPL2
 */
$languages = elgg_get_file_list(elgg_get_plugins_path() . "flexible_friendlytime/languages/", array(), array(), array('.php'));

foreach($languages as $langpath){
  $language = basename($langpath, '.php');
?>
	<div style="padding: 10px; margin: 15px; border: 2px solid #343434">
	<h1><?php echo elgg_echo('flexible_friendlytime:language:settings', array($language)); ?></h1>
	<br><br>
  <?php
  $options_values = array(
    1 => elgg_echo('flexible_friendlytime:elgg:default'),
    2 => elgg_echo('flexible_friendlytime:format:1', array(flexible_friendlytime_translate('M j, Y'), flexible_friendlytime_translate('g:ia'))),
    'Y-m-d H:i' => flexible_friendlytime_translate('Y-m-d H:i'),
    'm/d/Y - H:i' => flexible_friendlytime_translate('m/d/Y - H:i'),
    'd/m/Y - H:i' => flexible_friendlytime_translate('d/m/Y - H:i'),
    'Y/m/d - H:i' => flexible_friendlytime_translate('Y/m/d - H:i'),
    'd.m.Y - H:i' => flexible_friendlytime_translate('d.m.Y - H:i'),
    'm/d/Y - g:ia' => flexible_friendlytime_translate('m/d/Y - g:ia'),
    'd/m/Y - g:ia' => flexible_friendlytime_translate('d/m/Y - g:ia'),
    'Y/m/d - g:ia' => flexible_friendlytime_translate('Y/m/d - g:ia'),
    'M j Y - H:i' => flexible_friendlytime_translate('M j Y - H:i'),
    'j M Y - H:i' => flexible_friendlytime_translate('j M Y - H:i'),
    'Y M j - H:i' => flexible_friendlytime_translate('Y M j - H:i'),
    'M j Y - g:ia' => flexible_friendlytime_translate('M j Y - g:ia'),
    'j M Y - g:ia' => flexible_friendlytime_translate('j M Y - g:ia'),
    'Y M j - g:ia' => flexible_friendlytime_translate('Y M j - g:ia'),
    'D, Y-m-d H:i' => flexible_friendlytime_translate('D, Y-m-d H:i'),
    'D, m/d/Y - H:i' => flexible_friendlytime_translate('D, m/d/Y - H:i'),
    'D, d/m/Y - H:i' => flexible_friendlytime_translate('D, d/m/Y - H:i'),
    'D, Y/m/d - H:i' => flexible_friendlytime_translate('D, Y/m/d - H:i'),
    'F j, Y - H:i' => flexible_friendlytime_translate('F j, Y - H:i'),
    'j F, Y - H:i' => flexible_friendlytime_translate('j F, Y - H:i'),
    'Y, F j - H:i' => flexible_friendlytime_translate('Y, F j - H:i'),
    'D, m/d/Y - g:ia' => flexible_friendlytime_translate('D, m/d/Y - g:ia'),
    'D, d/m/Y - g:ia' => flexible_friendlytime_translate('D, d/m/Y - g:ia'),
    'D, Y/m/d - g:ia' => flexible_friendlytime_translate('D, Y/m/d - g:ia'),
    'F j, Y - g:ia' => flexible_friendlytime_translate('F j, Y - g:ia'),
    'j F Y - g:ia' => flexible_friendlytime_translate('j F Y - g:ia'),
    'Y, F j - g:ia' => flexible_friendlytime_translate('Y, F j - g:ia'),
    'j. F Y - G:i' => flexible_friendlytime_translate('j. F Y - G:i'),
    'l, F j, Y - H:i' => flexible_friendlytime_translate('l, F j, Y - H:i'),
    'l, j F, Y - H:i' => flexible_friendlytime_translate('l, j F, Y - H:i'),
    'l, Y,  F j - H:i' => flexible_friendlytime_translate('l, Y,  F j - H:i'),
    'l, F j, Y - g:ia' => flexible_friendlytime_translate('l, F j, Y - g:ia'),
    'l, j F Y - g:ia' => flexible_friendlytime_translate('l, j F Y - g:ia'),
    'l, Y,  F j - g:ia' => flexible_friendlytime_translate('l, Y,  F j - g:ia'),
    'l, j. F Y - G:i' => flexible_friendlytime_translate('l, j. F Y - G:i'),
    
  );

  echo "<label>" . elgg_echo('flexible_friendlytime:label:format1') . "</label><br>";
  
  $field = 'format1' . $language;
  $params = array(
  	'name' => 'params[format1' . $language . ']',
  	'value' => !empty($vars['entity']->$field) ? $vars['entity']->$field : 1,
  	'options_values' => $options_values, 
  );

  echo elgg_view('input/pulldown', $params);

  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  $field = 'format1override' . $language;
  echo elgg_echo('flexible_friendlytime:label:format:override', array('<a href="http://php.net/manual/en/function.date.php" target="_blank">date()</a>')) . ": ";
  echo elgg_view('input/text', array('name' => 'params[format1override' . $language . ']', 'value' => $vars['entity']->$field, 'style' => 'width: 80px;'));

  echo "<br><br>";
  $field = 'breaktime' . $language;
  echo "<label>" . elgg_echo('flexible_friendlytime:label:breaktime') . "</label><br>";
  echo "x = " . elgg_view('input/text', array('name' => 'params[breaktime' . $language . ']', 'value' => $vars['entity']->$field, 'style' => 'width: 80px;'));

  echo "<br><br>";
  echo "<label>" . elgg_echo('flexible_friendlytime:label:format2') . "</label><br>";

  $field = 'format2' . $language;
  $params['name'] = 'params[format2' . $language . ']';
  $params['value'] = !empty($vars['entity']->$field) ? $vars['entity']->$field : 1;
  echo elgg_view('input/pulldown', $params);

  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
  $field = 'format2override' . $language;
  echo elgg_echo('flexible_friendlytime:label:format:override', array('<a href="http://php.net/manual/en/function.date.php" target="_blank">date()</a>')) . ": ";
  echo elgg_view('input/text', array('name' => 'params[format2override' . $language . ']', 'value' => $vars['entity']->$field, 'style' => 'width: 80px;'));


  echo "<br><br>";
  echo "<label>" . elgg_echo('flexible_friendlytime:label:offset') . "</label><br>";

  $field = 'offset' . $language;
  $params = array(
    'name' => 'params[offset' . $language . ']',
  	'value' => empty($vars['entity']->$field) ? 0 : $vars['entity']->$field
  );

  for($i=-24; $i<25; $i++){
    if($i > 0){
      $prefix = '+';
    }
    else{
      $prefix = '';  
    }
    
    $params['options_values'][$i] = $prefix.$i;
  }

  echo elgg_view('input/pulldown', $params);
?>

	</div>

<?php 
}
?>