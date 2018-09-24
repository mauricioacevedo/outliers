<?php

/**
 * SettingFormModel class.
 * SettingFormModel is the data structure for keeping
 */
class SettingFormModel extends CFormModel
{
	public $hostname;
	public $user;
	public $password;
	public $dataBase;
	public $sitename;
	public $copyright;
	public $avatarPath;
	public $application;
	public $password_app;
	public $massUploadFilePath;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('hostname,user,database,sitename,copyright,avatarPath,application,password_app,massUploadFilePath', 
                              'required',
                              'message'=>'Este campo es obligatorio'),			
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'hostname'=>'Instancia Base de Datos',
			'user'=>'Usuario de BD',
			'password'=>'Contraseña',
			'dataBase'=>'Esquema',
			'sitename'=>'Nombre del Sitio',
			'copyright'=>'CopyRight',
			'avatarPath'=>'Ruta donde se guarta la foto de perfil',
			'application'=>'Nombre aplicación (registrado en delphos)',
			'password_app'=>'Clave aplicación (registrada en delphos)',
			'massUploadFilePath'=>'Ruta que se utilizara para cargas masivas',
		);
	}		
	
}