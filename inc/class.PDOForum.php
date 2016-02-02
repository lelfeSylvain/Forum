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
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
    private function __construct(){
    PDOForum::$monPdo = new PDO(PDOForum::$serveur.';'.PDOForum::$bdd, PDOForum::$user, PDOForum::$mdp); 
            PDOForum::$monPdo->query("SET CHARACTER SET utf8");
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
    
    private function logSQL($sql){
        $_SESSION['req']=$sql;
    }
	
    function getInfoUtil($name){
        $sql="select num, pseudo, mdp, nom, prenom, tsDerniereCx from ".PDOForum::$prefixe."util where pseudo='".$name."'";
        $moi->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetch();
        return $ligne;    
    }
    
    function setDerniereCx($num){
        $date = new DateTime();
        $sql="update ".PDOForum::$prefixe."util set tsDerniereCx ='".$date->format('Y-m-d H:i:s')."' where num=".$num;
        $moi->logSQL($sql);
        $rs =  PDOForum::$monPdo->exec($sql);
    }
}
