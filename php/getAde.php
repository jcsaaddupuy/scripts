<?php


if(isset($_GET["ressource"])){
switch($_GET["ressource"]){


case "M2T" : $res="124";break;
case "M2D" : $res="138";break;
default : $res="123";

}

exec("./ade2ics-v3.3.pl -s UJF -l voirIMA -p 'ima' -n ".$res,$output);
header('Content-type: text/calendar');
for($i=0;$i<sizeof($output);$i++)
	echo $output[$i]."\n";
}
else
echo "No ressource setted !";


?>
