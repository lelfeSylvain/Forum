<?php

    include_once 'inc/class.MakeLog.php';
/**
 * Modèle du projet : permet d'accéder aux données de la BD
 * La classe est munie d'un outil pour logger les requêtes
 *
 * @author sylvain
 * @date janvier-février 2016
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
   	
    /** renvoie les informations sur un utilisateur dont le pseudo est passé en paramètre
     * 
     * @param type $name : pseudo de l'utilisateur
     * @return type toutes les informations sur un utilisateur
     */
    function getInfoUtil($name){
        $sql="select num, pseudo, mdp, nom, prenom, tsDerniereCx from ".PDOForum::$prefixe."util where pseudo='".$name."'";
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetch();
        return $ligne;    
    }
    
    /** met à jour la dernière connexion/activité d'un utilisateur
     * 
     * @param type $num : id de l'utilisateur
     */
    function setDerniereCx($num){
        $date = new DateTime();
        $sql="update ".PDOForum::$prefixe."util set tsDerniereCx ='".$date->format('Y-m-d H:i:s')."' where num=".$num;
        $this->logSQL($sql);
        $rs =  PDOForum::$monPdo->exec($sql);
    }
    
    /** insère un nouvel utilisateur dans la base
     * 
     */
    // TODO : Pour le moment, on ajoute que le pseudo et le mdp
    // il faut aussi enregistrer les autres propriétés
    function setNouveauUtil($pseudo,$mdp){
        $sql="insert into ".PDOForum::$prefixe."util (pseudo, mdp) values ('".$pseudo."','".$mdp."')";
        $this->logSQL($sql);
        $rs =  PDOForum::$monPdo->exec($sql);
        return $rs;
    }
	
    /** renvoie tous les RUBRIQUES contenues dans celle passée en paramètre
     *  et compte combien de post/rubrique sont contenus dans celles-ci
     * 
     * @param type $numRubrique : id de la rubrique parente
     * @param type $etat : etat = 0 effacé, 1 créé, 2 publié, 3 modifié, 4 modéré
     * @return type : résultat de la requête
     */

    function getRubriquesIncluses($numRubrique=1,$etat=2){
        $sql="select titre, p.num as pnum  ,estRubrique,corps,pseudo,tsCreation, codeEtat, lib, tsDerniereModif from ".PDOForum::$prefixe."util u, ".PDOForum::$prefixe."post p, ".PDOForum::$prefixe."etatPost e ";
        $sql = $sql."where codeEtat=e.code and numAuteur=u.num "; // jointures
        $sql = $sql."and codeEtat >=".$etat." and estRubrique >0 ";
        $sql=$sql."and  (numPostParent =".$numRubrique." or p.num=".$numRubrique.") ";
        $sql = $sql."order by  p.num asc";
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetchAll();
        return $ligne; 
    }

    /** renvoie le numéro de la rubrique parent d'un post donné
     * 
     * @param type $num : l'Id du post
     * @return type : l'id du parent
     */
    function getRubriqueMere($num){
        $sql = "select numPostParent from ".PDOForum::$prefixe."post p ";
        $sql = $sql."where num=".$num;
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetch();
        return $ligne['numPostParent'];
    }

    /** renvoie tous les posts contenus dans une rubrique ($numRubrique)
     * dont l'état de publication a été passé en paramètre
     * 
     * 
     * @param type $numRubrique : id de la rubrique parente
     * @param type $etat : etat = 0 effacé, 1 créé, 2 publié, 3 modifié, 4 modéré
     * @return type : résultat de la requête
     */

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
    /** calcule le prochain id de la table post
     * 
     * @return type : entier id probable
     */
    function getProchainNumero(){
        $sql="select max(num)+1 as next from ".PDOForum::$prefixe."post";
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetch();
        return $ligne['next'];
    }
    /** retourne le niveau de la rubrique passée en paramètre
     * 
     * @param type $num : id de la rubrique
     * @return type le niveau de la rubrique 
     */
    function getNiveau($num){
        $sql="select estRubrique from ".PDOForum::$prefixe."post where num=".$num;
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetch();
        return $ligne['estRubrique']; 
    }
    
    /** insère une rubrique dans la BD
     * 
     * @param type $num : id de la rubrique parente 
     * @param type $titre : titre de la rubrique
     * @param type $auteur : id de l'auteur de la rubrique
     * @return type : l'id du nouvel article
     */
    // TODO : l'inclusion d'une rubrique inférieur à une rubrique de niveau 1 peut poser problème
    function ajouterRubrique($num, $titre,$auteur){
        $estRub=$this->getNiveau($num)-1;
        if ( $estRub<1) {$estRub=1;}
        $sql="insert into ".PDOForum::$prefixe."post (numPostParent, estRubrique,codeEtat, titre, numAuteur) values (";
        $sql= $sql.$num.", ".$estRub.",2,'".$titre."',".$auteur.")";
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->exec($sql);
        return PDOForum::$monPdo->lastInsertId();
    }
    /** insère un article dans la BD
     * 
     * @param type $num : id du post parent (rubrique ou article)
     * @param type $titre : titre de l'article
     * @param type $auteur : id de l'auteur de l'article
     * @param type $post : texte de l'article
     * @return type : l'id du nouvel article
     */
    function ajouterPost($num, $titre,$auteur,$post){
        $this->setArticleToRubrique($num);
        $sql="insert into ".PDOForum::$prefixe."post (numPostParent, estRubrique,codeEtat, titre, numAuteur, corps) values (";
        $sql= $sql.$num.", 0,2,'".$titre."',".$auteur.",'".$post."')";
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->exec($sql);
        return PDOForum::$monPdo->lastInsertId();
    }
    
    /** renvoie un post dont l'identifiant est passé en paramètre
     * Fonctionne aussi avec une rubrique
     * @param type $num identifiant du post à afficher
     * @return type tableau décrivant un post
     */
    
    function getPost($num){
        $sql="select titre, pseudo, corps, tsCreation, codeEtat, lib, tsDerniereModif,estRubrique, p.num as pnum , estRubrique, numPostParent from ";
        $sql = $sql.PDOForum::$prefixe."util u, ".PDOForum::$prefixe."post p,".PDOForum::$prefixe."etatPost e ";
        $sql = $sql."where codeEtat=e.code and numAuteur=u.num "; // jointures
        $sql = $sql."and   p.num =".$num." ";
        $this->logSQL($sql);
        $rs = PDOForum::$monPdo->query($sql);
        $ligne = $rs->fetch();
        return $ligne; 
    }
    /** L'article passé en paramètre devient une rubrique
     * 
     * @param type $num : l'id de l'article
     */
    // TODO : l'inclusion d'une rubrique inférieur à une rubrique de niveau 1 peut poser problème
    function setArticleToRubrique($num){
        $post=  $this->getPost($num);
        if (!$post['estRubrique']) { // si l'article n'est pas une rubrique
            $monNiveau= $this->getNiveau($post['numPostParent'])-1;
            if ($monNiveau<1) $monNiveau=1;
            $sql="update ".PDOForum::$prefixe."post set estRubrique=".$monNiveau." where num=".$num;
            $rs = PDOForum::$monPdo->exec($sql);
        }
    }
}
