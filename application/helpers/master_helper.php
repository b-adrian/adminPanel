<?php
function controller() {
	$CI = &get_instance();
	return $CI -> uri -> segment(1);
}

function action() {
	$CI = &get_instance();
	return $CI -> uri -> segment(2);
}

function item() {
	$CI = &get_instance();
	return $CI -> uri -> segment(3);
}
function br2nl($string)
{
    return preg_replace('|<br />|', "\n", $string);
}
function parent_url() {
	$CI = &get_instance();
	return $CI -> config -> slash_item('parent_url');
}
function pr($object, $die = false) {
	echo "<pre>";
	var_dump($object);
	echo "</pre>";
	if ($die == 1) {
		die("<span style='color:red;'><em>Script was killed on demand!</em></span>");
	}
}

function num_to_letters_simple($num, $sep = '') {
	$num = strval($num);
	if ($num == "0")
		return "zero";
	for ($i = 0; $i < strlen($num); ++$i)
		if (!is_numeric($num[$i]))
			return "[NaN]";
	if (strlen($num) > strlen("999999999999"))
		return "[huge]";
	$conv = "";
	$level = 0;
	$current = "";
	while (strlen($num) > 0) {
		if (strlen($num) > 3) {
			$current = substr($num, (strlen($num) - 3));
			$num = substr($num, 0, strlen($num) - 3);
		} else {
			$current = $num;
			$num = "";
		}
		$crt = ($current != "000") ? num_to_string($current, $level, $sep) : '';
		$conv = $crt . $conv;
		++$level;
	}
	return $conv;
}

/**
 * Methoda de conversie a grupurilor de 3 cifre
 **/
function num_to_string($nr, $level, $sep = '') {
	$val = intval($nr);
	if ($val == 0)
		return "";
	$decun = $val % 100;
	$hndr = floor($val / 100);
	$levels = array('single' => array('', 'mie', 'milion', 'miliard'), 'many' => array('', 'mii', 'milioane', 'miliarde'));
	// Sufixul grupului
	$sfx = $levels[($val == 1) ? 'single' : 'many'][$level];
	// Diverse forme pe care numerele le pot lua, utilizate mai jos in functie de caz
	$digits = array( array("", "unu", "doi", "trei", "patru", "cinci", "sase", "sapte", "opt", "noua"), array("", "un", "doua", "trei", "patru", "cinci", "sase", "sapte", "opt", "noua"), array("", "o", "doua", "trei", "patru", "cinci", "sase", "sapte", "opt", "noua"), array("", "un", "doi", "trei", "patru", "cinci", "sai", "sapte", "opt", "noua"), array("", "un", "doua", "trei", "patru", "cinci", "sai", "sapte", "opt", "noua"), );
	// Mai jos e algoritmul de conversie asa cum l-am gandit eu (admit ca nu e perfect, dar isi face treaba)
	$text = $digits[2][$hndr] . $sep . (($hndr == 1) ? 'suta' : (($hndr > 1) ? 'sute' : '')) . $sep;
	if ($decun == 0)
		return $text . $sep . $sfx . $sep;
	if ($decun < 10)
		return $text . $digits[(($level == 0) ? 0 : (($level == 1) ? ($hndr > 0 ? 0 : 2) : 3))][$decun] . $sep . $sfx . $sep;
	if ($decun == 10)
		return $text . 'zece' . $sep . $sfx . $sep;
	if ($decun < 20)
		return $text . $digits[3][$decun % 10] . 'sprezece' . $sep . $sfx . $sep;
	return $text . $digits[4][$decun / 10] . 'zeci' . $sep . (($decun % 10) == '0' ? '' : ('si' . $sep . $digits[0][$decun % 10] . $sep)) . (($level > 0) ? ('de' . $sep) : '') . $sfx . $sep;
}
