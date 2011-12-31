<?php
/**
 * Author: Matt Beckett
 * Website: http://clever-name.com
 * 
 * License: GPL2
 */
?>
<div style="padding: 20px;">

<?php
$options_values = array(
    1 => elgg_echo('flexible_friendlytime:elgg:default'),
    2 => elgg_echo('flexible_friendlytime:format:1', array(date('M j, Y'), date('g:ia'))),
    'Y-m-d H:i' => date('Y-m-d H:i'),
    'm/d/Y - H:i' => date('m/d/Y - H:i'),
    'd/m/Y - H:i' => date('d/m/Y - H:i'),
    'Y/m/d - H:i' => date('Y/m/d - H:i'),
    'd.m.Y - H:i' => date('d.m.Y - H:i'),
    'm/d/Y - g:ia' => date('m/d/Y - g:ia'),
    'd/m/Y - g:ia' => date('d/m/Y - g:ia'),
    'Y/m/d - g:ia' => date('Y/m/d - g:ia'),
    'M j Y - H:i' => date('M j Y - H:i'),
    'j M Y - H:i' => date('j M Y - H:i'),
    'Y M j - H:i' => date('Y M j - H:i'),
    'M j Y - g:ia' => date('M j Y - g:ia'),
    'j M Y - g:ia' => date('j M Y - g:ia'),
    'Y M j - g:ia' => date('Y M j - g:ia'),
    'D, Y-m-d H:i' => date('D, Y-m-d H:i'),
    'D, m/d/Y - H:i' => date('D, m/d/Y - H:i'),
    'D, d/m/Y - H:i' => date('D, d/m/Y - H:i'),
    'D, Y/m/d - H:i' => date('D, Y/m/d - H:i'),
    'F j, Y - H:i' => date('F j, Y - H:i'),
    'j F, Y - H:i' => date('j F, Y - H:i'),
    'Y, F j - H:i' => date('Y, F j - H:i'),
    'D, m/d/Y - g:ia' => date('D, m/d/Y - g:ia'),
    'D, d/m/Y - g:ia' => date('D, d/m/Y - g:ia'),
    'D, Y/m/d - g:ia' => date('D, Y/m/d - g:ia'),
    'F j, Y - g:ia' => date('F j, Y - g:ia'),
    'j F Y - g:ia' => date('j F Y - g:ia'),
    'Y, F j - g:ia' => date('Y, F j - g:ia'),
    'j. F Y - G:i' => date('j. F Y - G:i'),
    'l, F j, Y - H:i' => date('l, F j, Y - H:i'),
    'l, j F, Y - H:i' => date('l, j F, Y - H:i'),
    'l, Y,  F j - H:i' => date('l, Y,  F j - H:i'),
    'l, F j, Y - g:ia' => date('l, F j, Y - g:ia'),
    'l, j F Y - g:ia' => date('l, j F Y - g:ia'),
    'l, Y,  F j - g:ia' => date('l, Y,  F j - g:ia'),
    'l, j. F Y - G:i' => date('l, j. F Y - G:i'),
    
);

echo "<label>" . elgg_echo('flexible_friendlytime:label:format1') . "</label><br>";

$params = array(
  'name' => 'params[format1]',
  'value' => !empty($vars['entity']->format1) ? $vars['entity']->format1 : 1,
  'options_values' => $options_values, 
);

echo elgg_view('input/pulldown', $params);

echo "&nbsp;&nbsp;&nbsp;&nbsp;";
echo elgg_echo('flexible_friendlytime:label:format:override', array('<a href="http://php.net/manual/en/function.date.php" target="_blank">date()</a>')) . ": ";
echo elgg_view('input/text', array('name' => 'params[format1override]', 'value' => $vars['entity']->format1override, 'style' => 'width: 80px;'));

echo "<br><br>";
echo "<label>" . elgg_echo('flexible_friendlytime:label:breaktime') . "</label><br>";
echo "x = " . elgg_view('input/text', array('name' => 'params[breaktime]', 'value' => $vars['entity']->breaktime, 'style' => 'width: 80px;'));

echo "<br><br>";
echo "<label>" . elgg_echo('flexible_friendlytime:label:format2') . "</label><br>";

$params['name'] = 'params[format2]';
$params['value'] = !empty($vars['entity']->format2) ? $vars['entity']->format2 : 1;
echo elgg_view('input/pulldown', $params);

echo "&nbsp;&nbsp;&nbsp;&nbsp;";
echo elgg_echo('flexible_friendlytime:label:format:override', array('<a href="http://php.net/manual/en/function.date.php" target="_blank">date()</a>')) . ": ";
echo elgg_view('input/text', array('name' => 'params[format2override]', 'value' => $vars['entity']->format2override, 'style' => 'width: 80px;'));


echo "<br><br>";
echo "<label>" . elgg_echo('flexible_friendlytime:label:offset') . "</label><br>";

$params = array(
  'name' => 'params[offset]',
  'value' => empty($vars['entity']->offset) ? 0 : $vars['entity']->offset
);

for($i=-24; $i<25; $i++){
  if($i > 0){
    $prefix = '+';
  }
  $params['options_values'][$i] = $prefix.$i;
}

echo elgg_view('input/pulldown', $params);
?>

</div>