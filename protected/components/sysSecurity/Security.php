<?php
/**
 * Description of security
 *
 * @author jnavarrm
 */
class Security extends CApplicationComponent {
    
     public function checkUser() { 
            if (!Yii::app()->user->isGuest && Yii::app()->controller->action->id != 'uniqueUser') {
                $Controller = new Controller;
                if (Yii::app()->session['userSessionTimeout'] < time()) {
                    Yii::app()->user->logout(); 
                    $Controller->redirect(array('/site/login'));
                } else {                    
                    if(!UsersAccess::uniqueUser()){
                        $Controller->redirect(Yii::app()->request->baseUrl.'/index.php?r=/site/uniqueUser');
                    }                    
                    $model = Sitesettings::model()->findByAttributes(array('id' => '1'));
                    Yii::app()->session['userSessionTimeout'] = time() + $model->session_timeout;
                    return true;
                }
            } else {
                return true;
            }
      } 
      
       public function checkPermissions($controller='', $action='') {
            if($action == '' && $controller == ''){
                $controller = strtolower(Yii::app()->controller->id);
                $action = strtolower(Yii::app()->controller->action->id);
            }
            $arrPermissions = array('deny', // deny all users
                'users' => array('*'),
            );
            $havePermission = false;
            $access = false;
            if ($controller != "" && $action != "" && Yii::app()->session['roles_delphos'] != '') {                
                $roles_delphos = Yii::app()->session['roles_delphos'];               //      print_r($roles_delphos); exit;
                foreach ($roles_delphos as $role) {  
                    foreach ($role->$controller as $key => $crud) {         
                        if($crud == $action){
                           $access = true; 
                           break;
                        }
                    }
                }                
                if($access){
                    $havePermission = true;
                    $arrPermissions = array();
                    $arrPermissions[] = 'allow';
                    $arrPermissions['actions'] = array(Yii::app()->controller->action->id);
                    $arrPermissions['users'] = array(Yii::app()->user->name);
                }
            } //print_r($arrPermissions);exit;
            return array($arrPermissions, $havePermission);
    }

    /**
     * Generate a random salt in the crypt(3) standard Blowfish format.
     *
     * @param int $cost Cost parameter from 4 to 31.
     *
     * @throws Exception on invalid cost parameter.
     * @return string A Blowfish hash salt for use in PHP's crypt()
     */
    public function blowfishSalt($cost) {
        if (!is_numeric($cost) || $cost < 4 || $cost > 31) {
            throw new Exception("el parametro debe ser entre 4 y 31");
        }
        $rand = array();
        for ($i = 0; $i < 8; $i += 1) {
            $rand[] = pack('S', mt_rand(0, 0xffff));
        }
        $rand[] = substr(microtime(), 2, 6);
        $rand = sha1(implode('', $rand), true);
        $salt = '$2a$' . sprintf('%02d', $cost) . '$';
        $salt .= strtr(substr(base64_encode($rand), 0, 22), array('+' => '.'));
        return $salt;
    }

    /**
     * 
     * @param string $text
     * @param string $tags
     * @param string $specialChars
     * @return type
     */
    public function tagsAllowed($text,$tags=NULL,$specialChars=NULL,$trim=TRUE) {
        $ALLOWED_TAGS       = NULL;
        $ALLOWED_CHAR       = NULL;
        $PATTERN            = NULL;
        $TEXTARRAY          = ARRAY();
       
        if(!empty($tags))
        {
           $ALLOWED_TAGS    = $tags; 
        }
        elseif($tags===FALSE)
        {
           $ALLOWED_TAGS    = ''; 
        }
        else
        {
            $ALLOWED_TAGS   = '<a>,<abbr>,<acronym>,<area>,<b>,<base>,<basefont>,<bdo>,<big>,<blockquote>,
               <body>,<br>,<button>,<caption>,<center>,<cite>,<code>,<col>,<colgroup>,<dd>,<div>,<dl>,<dt>,
               <em>,<fieldset>,<font>,<form>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<head>,<hr>,<html>,<i>,<img>,
               <label>,<legend>,<li>,<link>,<map>,<menu>,<meta>,<noscript>,<ol>,<optgroup>,<option>,<p>,
               <pre>,<q>,<s>,<samp>,<select>,<small>,<span>,<strike>,<strong>,<style>,<sub>,<sup>,<table>,
               <tbody>,<td>,<textarea>,<tfoot>,<th>,<thead>,<title>,<tr>,<tt>,<u>,<ul>';
        }
        $text               = strip_tags($text, $ALLOWED_TAGS);  
        $text               = str_replace(', ',',',$text);  
        $text               = str_replace(' ,',',',$text);  
        if($trim===true)
        {
            $text           = str_replace(' ', '', $text);
        }
        if(!empty($specialChars))
        {            
            $PATTERN        = $specialChars;
            $ALLOWED_CHAR   = preg_replace($PATTERN,"|",$text); 
            $ALLOWED_CHAR   = explode("|", $ALLOWED_CHAR);
            
            foreach($ALLOWED_CHAR as $row)
            { 
                if(strlen($row)>0)
                { 
                    $TEXTARRAY[]  = $row; 
                }
            }
            $text = $TEXTARRAY;
        }
        else{
            
            $text           = addslashes($text);
            $text           = htmlentities($text);
        }
        
        return $text;
    }
}
