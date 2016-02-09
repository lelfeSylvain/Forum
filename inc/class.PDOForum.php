<?php


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
    // enregistre la dernière requête faite dans un fichier log
    private function logSQL($sql){
        $_SESSION['req']=$sql;
        $this->ajouterLog($this->logSQL,$sql);
        if ($this->modeDebug) echo $sql;
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
	
	// renvoie tous les posts dont l'état de publication a été passé en paramètre
	// etat = 0 effacé, 1 créé, 2 publié, 3 modifié, 4 modéré
	// niveau rubrique = 255 : rubrique principale, jamais affiché, 
	// 254 : premier niveau; 253 : 2e niveau etc.
	// 0 : un simple article
	function getToutesLesRubriques($niveauRubrique=254,$etat=2){
		$sql="select titre, p.num as pnum , count(*) as nb ,estRubrique from ".PDOForum::$prefixe."util u, ".PDOForum::$prefixe."post p, ".PDOForum::$prefixe."etatPost e ";
		$sql = $sql."where codeEtat=e.code and numAuteur=u.num "; // jointures
		$sql = $sql."and codeEtat >=".$etat." and  estRubrique >=".$niveauRubrique." ";
		$sql = $sql."group by titre, p.num, estRubrique ";
		$sql = $sql."order by p.num asc, estRubrique desc, tsDerniereModif desc";
		$this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetchAll();
        return $ligne; 
	}
	
	
	
	// renvoie tous les posts d'une rubrique dont l'état de publication a été passé en paramètre
	// etat = 0 effacé, 1 créé, 2 publié, 3 modifié, 4 modéré
	// niveau rubrique = 255 : rubrique principale, jamais affiché, 
	// 254 : premier niveau; 253 : 2e niveau etc.
	// 0 : un simple article
	function getTousLesPosts($numRubrique=254,$etat=2){
		$sql="select titre, pseudo, corps, tsCreation, codeEtat, lib, tsDerniereModif,estRubrique, p.num as pnum  from ";
		$sql = $sql.PDOForum::$prefixe."util u, ".PDOForum::$prefixe."post p,".PDOForum::$prefixe."etatPost e ";
		$sql = $sql."where codeEtat=e.code and numAuteur=u.num "; // jointures
		$sql = $sql."and codeEtat >=".$etat." and  (numPostParent =".$numRubrique." or p.num=".$numRubrique.") ";
		$sql = $sql."order by  estRubrique desc, tsDerniereModif desc";
		$this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetchAll();
        return $ligne; 
	}
}
