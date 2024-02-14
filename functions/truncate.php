<?php
/*
 * Truncate HTML Text: Truncates text in HTML while preserving the tags and the HTML validity 
 * Jonas Raoni Soares da Silva <http://raoni.org>
 * https://github.com/jonasraoni/php-truncate-html-text
 */
function truncate($s, $l, $e = '...', $isHTML = false, $closeTags = true){
	$i = 0;
	$tags = array();
	if($isHTML){
		preg_match_all('/<[^>]+>([^<]*)/', $s, $m, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
		foreach($m as $o){
			if($o[0][1] - $i >= $l)
				break;
			$t = substr(strtok($o[0][0], " \t\n\r\0\x0B>"), 1);
			if($t[0] != '/' && $t[strlen($t) - 1] != '/')
				$tags[] = $t;
			else if(end($tags) == substr($t, 1))
				array_pop($tags);
			$i += $o[1][1] - $o[0][1];
		}
	}
	return substr($s, 0, $l = min(strlen($s), $l + $i)) . ($closeTags && count($tags = array_reverse($tags)) ? '</' . implode('></', $tags) . '>' : '') . (strlen($s) > $l ? $e : '');
}