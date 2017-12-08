<?php
namespace Hotspot\AccessPointBundle\Helper;
class UtilHelper
{
static public function add1ToMac($mac){
	//$mac='A4-2B-B0-AC-78-9C';
	$sub=explode("-",$mac);

	//var_dump($sub[4]);
	//var_dump($sub[5]);
	if(count($sub)<5) return "";
	if($sub[5]=="FF"){
		$sub[5]="00";
		$sub[4]=dechex(hexdec($sub[4])+1);
		if(strlen($sub[4])==1) $sub[4]="0".$sub[4];

	}
	else{
		$sub[5]=dechex(hexdec($sub[5])+1);
		if(strlen($sub[5])==1) $sub[5]="0".$sub[5];
	}

	$newMac=strtoupper(implode("-",$sub));
	//var_dump($newMac);
	return $newMac;
}
static public function subtract1ToMac($mac){
	//$mac='A4-2B-B0-AC-78-9C';
	$sub=explode("-",$mac);

	//var_dump($sub[4]);
	//var_dump($sub[5]);
	if(count($sub)<5) return "";
	if($sub[5]=="00"){
		$sub[5]="FF";
		$sub[4]=dechex(hexdec($sub[4])-1);
		if(strlen($sub[4])==1) $sub[4]="0".$sub[4];
	}
	else{
		$sub[5]=dechex(hexdec($sub[5])-1);
		if(strlen($sub[5])==1) $sub[5]="0".$sub[5];
	}

	$newMac=strtoupper(implode("-",$sub));
	//var_dump($newMac);
	return $newMac;
}
}