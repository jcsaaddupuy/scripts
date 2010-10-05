<?php

/*
	Simple script qui permet d'exposer la sortie de ade2ics.pl sur un serveur web.
	
	Auteurs : 
	Pierre-Louis Fort <fort.pierrelouis@gmail.com>
	Jean-Christophe Saad-Dupuy <saad.dupuy@gmail.com>

*/

/*
	Do What The Fuck you want to Public License

	Version 1.0, March 2000
	Copyright (C) 2000 Banlu Kemiyatorn (]d).
	136 Nives 7 Jangwattana 14 Laksi Bangkok
	Everyone is permitted to copy and distribute verbatim copies
	of this license document, but changing it is not allowed.

	Ok, the purpose of this license is simple
	and you just

	DO WHAT THE FUCK YOU WANT TO.
*/

$ADE2ICS="./ade2ics-v3.3.pl";
$FAC="UJF";
$LOGIN="voirIMA";
$PWD="ima";

#echo "Up";
$_GET["ressource"]="M1";

if(isset($_GET["ressource"])){
	switch($_GET["ressource"]){
		case "M2T" : $res="124";break;
		case "M2D" : $res="138";break;
		case "M1" : $res="5";break;
		default : $res="123";
	}

	exec( $ADE2ICS." -s ".$FAC." -l ".$LOGIN." -p '".$PWD."' -n ".$res,$output);
	#echo "After EXEC";
	//On pose le mime type
	header('Content-type: text/calendar');

	/* 
	$output est un tableau contenant chaque ligne de sortie de la console dans une entrée du tableau
	ce qui nous force à le parcourir dans une boucle pour l'afficher
	*/	
	for($i=0; $i<sizeof($output); $i++){
		echo $output[$i]."\n";
	}
}
else{
	echo "No ressource setted !\n";
}

?>
