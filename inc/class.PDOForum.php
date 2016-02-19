<?php

    include_once 'inc/class.MakeLog.php';
/**
 * Modèle du projet : permet d'accéder aux données de la BD
 * La classe est munie d'un outil pour logger les requêtes
 *
 * @author sylvain
 */
class PDOForum {
    // paramètres d'accès au SGBD
    private static $serveur='mysql:host=localhost';
    private static $bdd='dbname=sylvain';   		
    private static $user='sylvain' ;    		
    private static $mdp='sylvain' ;
    // préfixe de toutes les tables
    public static $prefixe='forum_';
    // classe technique permettant d'accéder au SGBD
    private static $monPdo;
    // pointeur sur moi-même (pattern singleton)
    private static $moi=null; 
    // active l'enregistrement des logs
    private  $modeDebug=true;
    private $monLog;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
    private function __construct(){
	PDOForum::$monPdo = new PDO(PDOForum::$serveur.';'.PDOForum::$bdd, PDOForum::$user, PDOForum::$mdp); 
        PDOForum::$monPdo->query("SET CHARACTER SET utf8");
        // initialise le fichier log
        $this->monLog = new MakeLog("erreurSQL","./","w");
            
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
    
	// enregistre la dernière requête faite dans un fichier log
    private function logSQL($sql){
        if ($this->modeDebug) {
            $this->monLog->ajouterLog($sql);
        }
    }
   	
	// renvoie les informations sur un utilisateur dont le pseudo est passé en paramètre
    function getInfoUtil($name){
        $sql="select num, pseudo, mdp, nom, prenom, tsDerniereCx from ".PDOForum::$prefixe."util where pseudo='".$name."'";
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetch();
        return $ligne;    
    }
    
    // met à jour la dernière connexion/activité d'un utilisateur
    function setDerniereCx($num){
        $date = new DateTime();
        $sql="update ".PDOForum::$prefixe."util set tsDerniereCx ='".$date->format('Y-m-d H:i:s')."' where num=".$num;
        $this->logSQL($sql);
        $rs =  PDOForum::$monPdo->exec($sql);
    }
    
    // ajoute un nouvel utilisateur dans la base
    // TODO : Pour le moment, on ajoute que le pseudo et le mdp
    // il faut aussi enregistrer les autres propriétés
    function setNouveauUtil($pseudo,$mdp){
        $sql="insert into ".PDOForum::$prefixe."util (pseudo, mdp) values ('".$pseudo."','".$mdp."')";
        $this->logSQL($sql);
        $rs =  PDOForum::$monPdo->exec($sql);
        return $rs;
    }
	
    // renvoie tous les RUBRIQUES contenues dans celle passée en paramètre
    //  dont l'état de publication a été passé en paramètre
    //  et compte combien de post/rubrique sont contenus dans celles-ci
    // etat = 0 effacé, 1 créé, 2 publié, 3 modifié, 4 modéré

    function getRubriquesIncluses($numRubrique=1,$etat=2){
        $sql="select titre, p.num as pnum  ,estRubrique from ".PDOForum::$prefixe."util u, ".PDOForum::$prefixe."post p, ".PDOForum::$prefixe."etatPost e ";
        $sql = $sql."where codeEtat=e.code and numAuteur=u.num "; // jointures
        $sql = $sql."and codeEtat >=".$etat." and estRubrique >0 ";
        $sql=$sql."and  (numPostParent =".$numRubrique." or p.num=".$numRubrique.") ";
        $sql = $sql."order by  p.num asc";
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetchAll();
        return $ligne; 
    }

    // renvoie le numéro de la rubrique parent d'un post(ou rubrique) donné
    function getRubriqueMere($num){
        $sql = "select numPostParent from ".PDOForum::$prefixe."post p ";
        $sql = $sql."where num=".$num;
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetch();
        return $ligne['numPostParent'];
    }

    // renvoie tous les posts contenus dans une rubrique ($numRubrique)
    // dont l'état de publication a été passé en paramètre
    // etat = 0 effacé, 1 créé, 2 publié, 3 modifié, 4 modéré

    function getPostsInclus($numRubrique=1,$etat=2){
        $sql="select titre, pseudo, corps, tsCreation, codeEtat, lib, tsDerniereModif,estRubrique, p.num as pnum  from ";
        $sql = $sql.PDOForum::$prefixe."util u, ".PDOForum::$prefixe."post p,".PDOForum::$prefixe."etatPost e ";
        $sql = $sql."where codeEtat=e.code and numAuteur=u.num "; // jointures
        $sql = $sql."and codeEtat >=".$etat." and estRubrique =0 ";
        $sql=$sql."and  numPostParent =".$numRubrique." ";
        $sql = $sql."order by  tsDerniereModif desc";
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetchAll();
        return $ligne; 
    }
    
    function getProchainNumero(){
        $sql="select max(num)+1 as next from ".PDOForum::$prefixe."post";
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetch();
        return $ligne['next'];
    }
    
    function getNiveau($num){
        $sql="select estRubrique from ".PDOForum::$prefixe."post where num=".$num;
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetch();
        return $ligne['estRubrique']-1; 
    }
    
    function ajouterRubrique($num, $titre,$auteur){
        $estRub=$this->getNiveau($num);
        if ( $estRub<0) {$estRub=0;}
        $sql="insert into ".PDOForum::$prefixe."post (numPostParent, estRubrique,codeEtat, titre, numAuteur) values (";
        $sql= $sql.$num.", ".$estRub.",2,'".$titre."',".$auteur.")";
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        
        return $rs;
    }
    
    function ajouterPost($num, $titre,$auteur,$post){
        $sql="insert into ".PDOForum::$prefixe."post (numPostParent, estRubrique,codeEtat, titre, numAuteur, corps) values (";
        $sql= $sql.$num.", 0,2,'".$titre."',".$auteur.",'".$post."')";
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        return $rs;
    }
}
