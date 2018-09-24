<?php

/**
 * Subdireccion Aplicaciones Corporativas
 * @author Joan Harriman Navarro M - jnavarrm@asesor.une.com.co
 * @author Jorge Arzuaga - jarzuas@asesor.une.com.co
 * @copyright UNE TELECOMUNICACIONES
 */
class authManager extends CWebUser {
    
    public $CodRespuesta;
    /**
     * Este método obtiene los permisos en formato JSON a parti dle nombre de usuario y los permisos asociados en la tabla tbl_permissions_roles
     * Sirve para aplicaciones que manejan permisos de forma local
     * 
     * @param type $username
     * @return string
     */
    public function getLocalPermissions($username) {
        if ($username != '') {
            $usersRoles = UsersRoles::model()->findAll(array('condition' => "username='" . $username . "'"));
            $permisos = array();
            $permisosTmp = '';
            $permisosJson = array();
            foreach ($usersRoles as $userRol) {
                $permisosRoles = PermissionsRoles::model()->findAll(array('condition' => "rol='" . $userRol->rol . "'"));
                foreach ($permisosRoles as $permisoRol) {
                    $permisosTmp[$permisoRol->controller][] = '"' . $permisoRol->action . '"';
                }
                foreach ($permisosTmp as $controller => $arrAction) {
                    $permisosJson[] = '"' . $controller . '":[' . implode(',', $arrAction) . ']';
                }
                $permisos[] = '"' . $userRol->rol . '":{' . implode(',', $permisosJson) . '}';
                $permisosTmp = '';
                $permisosJson = array();
            }
            return "{" . implode(',', $permisos) . "}";
        }
    }
    

    /**
     * Este método realiza el login contra delphos contra el directorio activo
     * 
     * @param string $username
     * @param string $password
     * @param object $users
     * @return boolean
     */
    public function getDelphosPermissions($username, $password, $users) {        
        $check = false;                
        $params['param'][] = array('login' => $username,
                                            'password' => $password,
                                            'aplicacion' => Yii::app()->params['delphos']['aplicacion'],
                                            'password_app' => Yii::app()->params['delphos']['password_app'],
                                );
        $wsResponse[] = Yii::app()->OssManager->exec('delphos', $params);              
        if ($wsResponse[0]->CodError == '' && !empty($wsResponse[0]->CodRespuesta) && $wsResponse[0]->CodRespuesta != '0') {     
            if ($users == NULL){
                $newUser = new Users();
                $newUser->user_id = '0';
                $newUser->samaccountname = $username;
                $newUser->user_status = 1;
				$newUser->passwd = crypt($password.rand(1000,9999), Yii::app()->sysSecurity->blowfishSalt(13));
				$newUser->passwd2 = crypt($password.rand(1000,9999), Yii::app()->sysSecurity->blowfishSalt(13));				                
                $newUser->Save();      
            }
            $this->CodRespuesta = $wsResponse[0]->CodRespuesta;
            $check = true;
        }
        return $check;        
    }
    
    /**
     * Este método realiza el autologin contra el directorio activo
     * 
     * @param type $username
     * @param string $password
     * @param object $users
     * @return boolean
     */
    public function getAutologinPermissions($username, $users) {        
        $check = false;
        $params['param'][] = array('login' => $username,
                                    'fuente' => 'DIR_ACT',
                                    'aplicacion' => Yii::app()->params['delphos']['aplicacion'],
                                    'password_app' => Yii::app()->params['delphos']['password_app'],
                                );
        $wsResponse[] = Yii::app()->OssManager->exec('autologin', $params);                             
        if (!empty($wsResponse[0]->CodRespuesta) && $wsResponse[0]->CodRespuesta != '0') {
            if ($users == NULL){
                $newUser = new Users();
                $newUser->user_id = '0';
                $newUser->samaccountname = $username;                        
                $newUser->user_status = 1;
				$newUser->passwd = crypt($username.'Ab.12'.rand(1000,9999), Yii::app()->sysSecurity->blowfishSalt(13));
				$newUser->passwd2 = crypt($username.'Ab.12'.rand(1000,9999), Yii::app()->sysSecurity->blowfishSalt(13));				                
                $newUser->Save();                
            }
            $this->CodRespuesta = $wsResponse[0]->CodRespuesta;
            $check = true;
        }
        return $check;
    }

}
