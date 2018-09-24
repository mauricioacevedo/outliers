<?php



class mailComponent extends CApplicationComponent {

    /**
     *
     * Función para enviar emails, utilizando la clase phpmailer
     * @author Jorge Arzuaga <jorgearzuaga1@hotmail.com>
     *
     * @param unknown_type $strMensaje
     * @param unknown_type $strAsunto
     * @param unknown_type $arrAddress $arrAddress['direccion'],$arrAddress['nombre']
     * @param unknown_type $arrFrom
     * @param unknown_type $arrReplyTo $arrReplyTo['direccion'],$arrReplyTo['nombre']
     * @return boolean|string
     */
    public function sendMail($strMensaje = '', $strAsunto = '', $arrAddress= '', $arrFrom = array(), $arrReplyTo = array(), $arrAdjunto = array(), $arrConCopia = array(), $arrConCopiaOculta = array()) {       
		require_once 'classphpmailer.php';
		 
        $mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch
        
        $mail->IsSMTP(); // telling the class to use SMTP
        try {
            //$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
            $mail->SMTPAuth = true;                  // enable SMTP authentication
            $mail->Host = PHPMailerHost; // sets the SMTP server
            $mail->Port = 25;                    // set the SMTP port for the GMAIL server
            $mail->Username = PHPMailerUsername; // SMTP account username
            $mail->Password = PHPMailerPassword;        // SMTP account password
            $mail->CharSet = "utf-8";

            $emailsNoEnviados = "";

            if (!isset($arrReplyTo['direccion']))
                $mail->AddReplyTo(PHPMailerReplyTo, PHPMailerReplyToName);
            else
                $mail->AddReplyTo($arrReplyTo['direccion'], $arrReplyTo['nombre']);

            /**
             * Dirección de envio para el correo
             */
            $arrAddress['direccion'][] = ISEmail;
            if (!empty($arrAddress)) {
                if (count($arrAddress['direccion']) > 1 || is_array($arrAddress['direccion'])) {
                    foreach ($arrAddress['direccion'] as $key => $array) {
                        if ($arrAddress['direccion'][$key] != '') {
                            if (filter_var($arrAddress['direccion'][$key], FILTER_VALIDATE_EMAIL) == true)
                                $mail->AddAddress($arrAddress['direccion'][$key], $arrAddress['nombre'][$key]);
                            else
                                $emailsNoEnviados .= $arrAddress['direccion'][$key] . ",";
                        }
                    }
                }
                else {
                    if (filter_var($arrAddress['direccion'][$key], FILTER_VALIDATE_EMAIL) == true)
                        $mail->AddAddress($arrAddress['direccion'], $arrAddress['nombre']);
                    else
                        $emailsNoEnviados .= $arrAddress['direccion'] . ",";
                }
            }
            /**
             * Dirección de envio para el correo, con copia
             */
            if (!empty($arrConCopia)) {
                if (count($arrConCopia['direccion']) > 1 || is_array($arrAddress['direccion'])) {
                    foreach ($arrConCopia['direccion'] as $key => $array) {
                        if ($arrConCopia['direccion'][$key] != '') {
                            if (filter_var($arrConCopia['direccion'][$key], FILTER_VALIDATE_EMAIL) == true)
                                $mail->AddCC($arrConCopia['direccion'][$key], $arrConCopia['nombre'][$key]);
                            else
                                $emailsNoEnviados .= $arrConCopia['direccion'][$key] . ",";
                        }
                    }
                }
                else {
                    if (filter_var($arrConCopia['direccion'][$key], FILTER_VALIDATE_EMAIL) == true)
                        $mail->AddCC($arrConCopia['direccion'], $arrConCopia['nombre']);
                    else
                        $emailsNoEnviados .= $arrConCopia['direccion'] . ",";
                }
            }

            /**
             * Dirección de envio para el correo, con copia oculta
             */
            if (!empty($arrConCopiaOculta)) {
                if (count($arrConCopiaOculta['direccion']) > 1 || is_array($arrAddress['direccion'])) {
                    foreach ($arrConCopiaOculta['direccion'] as $key => $array) {
                        if ($arrConCopiaOculta['direccion'][$key] != '') {
                            if (filter_var($arrConCopiaOculta['direccion'][$key], FILTER_VALIDATE_EMAIL) == true)
                                $mail->AddBCC($arrConCopiaOculta['direccion'][$key], $arrConCopiaOculta['nombre'][$key]);
                            else
                                $emailsNoEnviados .= $arrConCopiaOculta['direccion'][$key] . ",";
                        }
                    }
                }
                else {
                    if (filter_var($arrConCopiaOculta['direccion'][$key], FILTER_VALIDATE_EMAIL) == true)
                        $mail->AddBCC($arrConCopiaOculta['direccion'], $arrConCopiaOculta['nombre']);
                    else
                        $emailsNoEnviados .= $arrConCopiaOculta['direccion'] . ",";
                }
            }


            if (!isset($arrFrom['direccion']) && isset($arrFrom['nombre']))
                $mail->SetFrom(PHPMailerFrom, $arrFrom['nombre']);
            else if (!isset($arrFrom['direccion']) && !isset($arrFrom['nombre']))
                $mail->SetFrom(PHPMailerFrom, PHPMailerFromName);
            else if (isset($arrFrom['direccion']) && isset($arrFrom['nombre']))
                $mail->SetFrom($arrFrom['direccion'], $arrFrom['nombre']);

            $mail->Subject = $strAsunto;
            $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
            $mail->MsgHTML($strMensaje);
            $mail->SetLanguage('es');
            /**
             * Archivos adjutnos
             */
            if (!empty($arrAdjunto)) {
                if (is_array($arrAdjunto)) {
                    foreach ($arrAdjunto as $key => $strRuta) {
                        $mail->AddAttachment($strRuta);      // attachment
                    }
                }
            }
            $envio = $mail->Send();
            if ($envio) {
                return array(true, $emailsNoEnviados, "Se envió mensaje con la acción ejecutada.");
            } else {
                return array(false, $emailsNoEnviados, "Mailer Error: " . $mail->ErrorInfo);
            }
        } catch (phpmailerException $e) {
            return array(false, $emailsNoEnviados, $e->errorMessage());
        } //Pretty error messages from PHPMailer
        catch (Exception $e) {
            return array(false, $emailsNoEnviados, $e->errorMessage());
        } //Boring error messages from anything else!
    }

}

?>
