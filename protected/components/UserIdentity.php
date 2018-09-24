<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    public $userstatus = NULL;
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate() {
        $users = NULL;
        $check = false;
        $model = Users::model();
        $users = $model->findByAttributes(array('samaccountname' => $this->username));
        $siteSettingModel = Sitesettings::model()->findByAttributes(array('id' => '1'));
        $oauthModel = Oauth::model();
        $oatuhId = $siteSettingModel->oauth;
        //$oauthDesc = $oauthModel->findByAttributes(array('id' => $oatuhId));
        $sessionid = session_id().date('_Ymdhis');
        
        //$arrOauth = array('externo','delphos');
        $arrOauth = array('externo');
        foreach ($arrOauth as $oauth){
            switch ($oauth) {
                case 'delphos':
                    /*$params['param'][] = array('login' => $this->username,
                                                'password' => $this->password,
                                                'aplicacion' => Yii::app()->params['delphos']['aplicacion'],
                                                'password_app' => Yii::app()->params['delphos']['password_app'],
                    );
                    $wsResponse[] = Yii::app()->OssManager->exec($oauthDesc->oauth, $params);              
                    if ($wsResponse[0]->CodError == '' && !empty($wsResponse[0]->CodRespuesta) && $wsResponse[0]->CodRespuesta != '0') {
                        if ($users != NULL) {
                            if (crypt($this->password, $users->passwd) !== $users->passwd) {
                                $users->passwd = crypt($this->password, Yii::app()->sysSecurity->blowfishSalt(13));
                                $users->SaveAttributes(array('passwd'));
                            }
                        } else {
                            $newUser = new Users();
                            $newUser->user_id = '0';
                            $newUser->samaccountname = $this->username;
                            $newUser->passwd = crypt($this->password, Yii::app()->sysSecurity->blowfishSalt(13));
                            $newUser->user_status = 1;
                            $newUser->Save();
                            $users = $model->findByAttributes(array('samaccountname' => $this->username));
                        }
                        $check = true;
                    }*/
			//print_r("AUTENTICANDO POR delphos<br>");
                    $wsResponse[]                       = new stdClass();
                    $wsResponse[0]->CodRespuesta = Yii::app()->authManager->getLocalPermissions($users->samaccountname);                                                                  
                    $check = true;
                    /*$check = Yii::app()->authManager->getDelphosPermissions($this->username, $this->password);
                    if($check){
                        $users = $model->findByAttributes(array('samaccountname' => $this->username));
                    }*/

                    break;           
                case 'externo':
			 //print_r("AUTENTICANDO POR externo<br>");
                    if ($users != NULL) {
                        if (crypt($this->password, $users->passwd) == $users->passwd) {
                        //if ($this->password == $users->passwd) {
                            $check = true;
                        }
                    } else {
                        $check = false;
                    }
                    #############SOLO PARA PRUEBAS LOCALES..####################
                   // $wsResponse[]                       = new stdClass();
                    //$wsResponse[0]->CodRespuesta        = (string)Ossconfig::model()->findByAttributes(array('configname'=>'localhost','defaultserver'=>'1'))->params;              
                    
                    if($check){
                        $wsResponse[0]->CodRespuesta = Yii::app()->authManager->getLocalPermissions($users->samaccountname);                 
                    }
                    break;
            }
        }
	
	//exit;
        /**
         * Se obtienen los permisos
         */
        if ($check) {
            /**
             * Aplica para la GRID en AjaxController
             */
            Yii::app()->session['extraParamsInsert'] = array('creadopor' => $users->samaccountname, 'fechacreacion' => 'now()');
            Yii::app()->session['extraParamsEdit'] 	= array('modificadopor' => $users->samaccountname, 'fechamodificacion' => 'now()');
            Yii::app()->session['extraFieldsFuncInsert'] = array('fechacreacion');
            Yii::app()->session['extraFieldsFuncUpdate'] = array('fechamodificacion'); 
            $modelAtt =Attachment::model()->findByPk($users->pic_profile_id);
            Yii::app()->session['file']             =  $modelAtt;
            Yii::app()->session['roles_delphos']    = json_decode(json_encode(json_decode($wsResponse[0]->CodRespuesta)));  
            $arrPermisos = array();
            $roles = array();
            foreach (Yii::app()->session['roles_delphos'] as $rol => $rolObj){                     
                    $nombre_roles_delphos[] = $rol;
                    if (is_object($rolObj) || is_array($rolObj)) {
                        foreach ($rolObj as $controller => $arrAction) {                            
                            foreach ($arrAction as $action) {
                                $arrPermisos[$rol][$controller][$action] = 1;
                                echo "$rol - $controller - $action<br>";
                            }
                        }                        
                    }
            }
            
            $users->cn = CHtml::encode($users->cn);
            Yii::app()->session['nombre_roles_delphos'] = $nombre_roles_delphos;
            Yii::app()->session['roles_permisos']   = $arrPermisos;          
            Yii::app()->session['users']            = $users;
            Yii::app()->session['sessionid']        = $sessionid;
            
            Yii::app()->session['username'] = $users->samaccountname;
            Yii::app()->session['userSessionTimeout'] = time()+$siteSettingModel->session_timeout;
            
            $users->sessionid = $sessionid;
            $users->update(array('sessionid'));  

            $modelUsersAccess = new UsersAccess();
            $modelUsersAccess->samaccountname = $users->samaccountname;
            $modelUsersAccess->ip = getenv('REMOTE_ADDR');
            $modelUsersAccess->sessionid = $sessionid;
            $modelUsersAccess->save();
                                                
            $modelAtt = Attachment::model()->findByPk($users->pic_profile_id);
            Yii::app()->session['file'] = $modelAtt;
        }

        if (!$check) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } /** Si no esta activo */ elseif ($users->user_status != 1) {
            $this->userstatus = Userstatus::model()->findByPk($users->user_status)->status;
            $check = false;
        } else {
            $this->errorCode = self::ERROR_NONE;
        }
        return $check;
    }

}
