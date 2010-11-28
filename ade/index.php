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
$CACHE_DIR="cache";


/**
* Fonctions utiles sur les chaines de caractères.
*/
function startswith($hay, $needle) {
  return substr($hay, 0, strlen($needle)) === $needle;
}

function endswith($hay, $needle) {
  return substr($hay, -strlen($needle)) === $needle;
}

/***
* Vérifie que le contenu du calendrier commence et se termine par des balises ICS
* @param calendar : contenu du calendrier au format ICS
* @return True si le parametre donné est bien formatté
*/
function isCompleteVCalendar($calendar){
	return (startswith($calendar, "BEGIN:VCALENDAR") && (endswith($calendar, "END:VCALENDAR")));
}
/**
* Ecrit le contenu content dans le fichier filename
* @param filename : nom du fichier à ecrire
* @param content : contenu à ecrire
*/
function writeToFile($filename, $content){
	$f=fopen($filename, "w");
	#echo $f;
	for($i=0; $i<sizeof($content); $i++){
		fwrite($f, $content[$i]);
	}
	fclose($f);
}
/***
* Lit le fichier dont le nom est donné en paramètre et le renvois
* @param : filename: nom du fichier à lire
* @return : le contenu du fichier
*/
function readFromFile($filename){
	$f=fopen($filename, "r");
	$content=fread($f, filesize($filename));	
	fclose($f);
	return $content;
}

function createFolder($folderName){
	if(!is_dir($folderName)){
		mkdir($folderName);
	}
}
//A virer pour livraison. Permet de lancer le script avec la variable initialisée hors contexte web.
$_GET["q"]="M2T";
if(isset($_GET["q"])){
	switch($_GET["q"]){
		case "M2T" : $res="124";$fname="M2T";break;
		case "M2D" : $res="138";$fname="M2G";break;
		case "M1" : $res="5";$fname="M1";break;
		case "M1G1" : $res="22";$fname="M1G1";break;
		case "M1G2" : $res="17";$fname="M1G2";break;
		//Default : M2 Miage \o/
		default : $res="123";$fname="default";
	}
	//On gere un cache si ADE plante
	$fname.=".ics";

	exec( $ADE2ICS." -s ".$FAC." -l ".$LOGIN." -p '".$PWD."' -n ".$res,$output);


	/*
		En cas d'erreur (contenu vide), on renvoie les infos contenues dans le cache.
	*/
	$calContent="";
	for($i=0;$i<sizeof($output);$i++){
		$calContent.=$output[$i];
	}
	
	//A virer pour livraison, permet de tester le bon fonctionnement du cache
	#$calContent="";
	if(isCompleteVCalendar($calContent)){
		createFolder($CACHE_DIR);
		writeToFile($CACHE_DIR."/".$fname, $output);
	}else{
		//!\\
		//Ici, si le cache n'a pas été crée un erreur sera levée.
		//Ne devrais jamais se produire si le déploiement prévois de créer les fichiers cache.
		$calContent=readFromFile($CACHE_DIR."/".$fname);
	}
	//On pose le mime type
	header('Content-type: text/calendar; charset=utf-8');
	echo $calContent;
}
else{
	echo "No ressource setted !\n";
}

?>
