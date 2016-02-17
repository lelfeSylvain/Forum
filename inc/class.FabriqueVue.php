<?php

/**
 * Description of class
 *
 * @author sylvain
 */
class FabriqueVue {
    private static $maFabrique = null;
 /**
 * Constructeur privé, crée l'instance de fabrique (pattern Singleton) 
 * 
 */				
    private function __construct(){
	
            
    }
    public function __destruct(){
            
    }
/**
 * Fonction statique qui crée l'unique instance de la classe
 * Appel : $instancePdoForum = PdoForum::getPdoForum();
 * @return l'unique objet de la classe PdoForum
 */
    public  static function getFabrique(){
            if(FabriqueVue::$maFabrique==null){
                    FabriqueVue::$maFabrique = new FabriqueVue();
            }
            return FabriqueVue::$maFabrique;  
    }
    
    public function getForm($form){
        switch($form){
            case 'rubrique' : 
                include "vues/v_creerRubrique.php";
                break;
            case 'post':
                break;
            case 'valider':
                break;
        }
    }
    
}
