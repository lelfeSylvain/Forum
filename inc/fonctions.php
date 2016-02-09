<?php 

function pluriel($n, $mot){
	if ($n>1) 
		return $n.' '.$mot."s ";
	else 
		return $n.' '.$mot." ";
}



?>
