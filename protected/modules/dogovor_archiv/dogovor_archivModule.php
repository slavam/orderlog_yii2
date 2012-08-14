<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dogovor_archiv
 *
 * @author v.kriuchkov
 */
class dogovor_archivModule extends CWebModule{
    public $defaultController = 'documents';
   // public $layout = "dogovor_archiv_main";
   public $modulename;

   public function beforeControllerAction($controller, $action)
        {
                if(parent::beforeControllerAction($controller, $action))
                {
                  $controller->layout = '/layouts/dogovor_archiv_main'; // path to your view 
                  return true;
                }
                else
                    return false;
        }

    function init()
    {
        $this->layout="dogovor_archiv_main";
	$this->setImport(array(
            'dogovor_archiv.models.*',
            'dogovor_archiv.components.*',
            ));
        
    }
}
?>
