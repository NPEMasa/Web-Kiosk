<?php
	$base_url = 'http://api.openweathermap.org/data/2.5/weather?q=nagoya&appid=';
# 	&appid is openweathermap api token.
	
	$response = file_get_contents($base_url);
	$result = json_decode($response,true);

	$rssdata = simplexml_load_file("http://www.security-next.com/feed");
	$nwrssdata = simplexml_load_file("https://news.yahoo.co.jp/pickup/rss.xml");

	$num_of_data = 7;
	$outdata = "";

?>
<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body class="bk">
<h1 id="time"></h1>
  <script>
    setTimeout("location.reload()",1800000);
    time();
    function time(){
	var now = new Date();
	document.getElementById("time").innerHTML = now.toLocaleString();
    }
    setInterval('time()',1000);
  </script>
<p>Weather<br />
<?php
        $ico = "http://openweathermap.org/img/w/".$result[weather][0][icon].".png";
	echo "<img src=".$ico." width='128' height='128'><br>";
	print($result[name]); echo "/"; print($result[weather][0][main]);
	echo "<br />";
	$fl1 = 273.15; $temp = $result[main][temp] - $fl1; print($temp);echo "℃";

?></p><br />

<p>Seurity News<br />
<?php
	for ($i=0; $i<$num_of_data; $i++){
		$entry = $rssdata->channel->item[$i]; 
		$date = date("Y/n/j", strtotime($entry->pubDate));
		$title = $entry->title; 
		$link = $entry->link; 

		#$outdata .= '<li><a href="' . $link . '">' . $date;
		$outdata .= '<li>' . $date;

		$outdata .= ' : <span>' . $title . '</span></li>';
	}

	echo '<ul>' . $outdata . '</ul>'; 
?></p><br />
<p>Yahoo News<br />
<?php
	$outdata = "";
	for ($i=0; $i<$num_of_data; $i++){
		$entry = $nwrssdata->channel->item[$i]; 
		$date = date("Y年 n月 j日", strtotime($entry->pubDate));
		$title = $entry->title; 
		$link = $entry->link; 

		#$outdata .= '<li><a href="' . $link . '">' . $date;
		$outdata .= '<li>' . $date;

		$outdata .= ' : <span>' . $title . '</span></li>';
	}

	echo '<ul>' . $outdata . '</ul>'; 
?></p>
<p>Finance<br />
<?php
#	&q is 'securities code'.
	$base_url = 'https://www.google.com/finance/getprices?p=7d&i=86400&x=TYO&q=';
	$base2_url = 'https://www.google.com/finance/getprices?p=7d&i=86400&x=TYO&q=';

	$data = fopen($base_url, "r");
	$data2 = fopen($base2_url, "r");

	$array = array();
	$array2 = array();
	while ($line = fgets($data)) {
    	array_push($array, $line);
	}
	while ($line = fgets($data2)) {
    	array_push($array2, $line);
	}
	$str = $array[14];
	$str2 = $array2[14];
	$res = explode(",", $str);
	$res2 = explode(",", $str2);

	echo "... ".$res[1]."円";
	echo "<br>";
	echo "... ".$res2[1]."円";

?>

</body>

