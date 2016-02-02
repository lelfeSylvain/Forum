<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of Class
 *
 * @author sylvain
 */
class PDOForum {
	private static $serveur='mysql:host=localhost';
	private static $bdd='dbname=sylvain';   		
	private static $user='sylvain' ;    		
	private static $mdp='sylvain' ;
	private static $monPdo;
	private static $moi=null;
	public static $prefixe='forum_';
	private  $dernierResultat=null;
	private  $modeDebug=false;
	private $logSQL="erreurSQL.log";
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
    private function __construct(){
		PDOForum::$monPdo = new PDO(PDOForum::$serveur.';'.PDOForum::$bdd, PDOForum::$user, PDOForum::$mdp); 
            PDOForum::$monPdo->query("SET CHARACTER SET utf8");
        fopen($this->logSQL,'w');    
    }
    public function __destruct(){
            PDOForum::$monPdo = null;
    }
/**
 * Fonction statique qui crée l'unique instance de la classe
 
 * Appel : $instancePdoForum = PdoForum::getPdoForum();
 
 * @return l'unique objet de la classe PdoForum
 */
    public  static function getPdoForum(){
            if(PDOForum::$moi==null){
                    PDOForum::$moi= new PDOForum();
            }
            return PDOForum::$moi;  
    }
    
    // ajoute une entrée dans le fichier log
	
	function ajouterLog($fichier,$message, $estErreur=false){
		$date = new DateTime();
		$msg = $date->format("Y-m-d H:i:s ");
		if ($estErreur) {// message en erreur
			$msg .="#### ERREUR : ";
		}
		$msg .= $message;
		//ajouter fonction ecriture
		$fp = fopen($fichier,'a+');
		fseek($fp,SEEK_END);
		$nouverr=$msg."\r\n";
		fputs($fp,$nouverr);
		fclose($fp); 
	}
    
    private function logSQL($sql){
        $_SESSION['req']=$sql;
        $this->ajouterLog($this->logSQL,$sql);
        if ($this->modeDebug) echo $sql;
    }
	
    function getInfoUtil($name){
        $sql="select num, pseudo, mdp, nom, prenom, tsDerniereCx from ".PDOForum::$prefixe."util where pseudo='".$name."'";
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetch();
        return $ligne;    
    }
    
    function setDerniereCx($num){
        $date = new DateTime();
        $sql="update ".PDOForum::$prefixe."util set tsDerniereCx ='".$date->format('Y-m-d H:i:s')."' where num=".$num;
        $this->logSQL($sql);
        $rs =  PDOForum::$monPdo->exec($sql);
    }
    
    function setNouveauUtil($pseudo,$mdp){
		$sql="insert into ".PDOForum::$prefixe."util (pseudo, mdp) values ('".$pseudo."','".$mdp."')";
		$this->logSQL($sql);
        $rs =  PDOForum::$monPdo->exec($sql);
        return $rs;
	}
	
	function getTousLesPosts($etat=2){
		$sql="select * from ".PDOForum::$prefixe."util u, ".PDOForum::$prefixe."post p,".PDOForum::$prefixe."etatPost e where codeEtat >=".$etat." and codeEtat=e.code and numAuteur=u.num order by estRubrique desc, tsDerniereModif desc";
		$this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetchAll();
        return $ligne; 
	}
}
