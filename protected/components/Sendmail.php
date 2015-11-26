<?php

/*
 * Our Custom Mail Class
 */

class Sendmail {
    function send($to, $subject, $body, $fromName = '', $from = '', $attachment = null) {
        if (MAILSENDBY == 'phpmail'):
            $this->sendPhpmail($to, $subject, $body, $attachment);
        elseif (MAILSENDBY == 'smtp'):
            Yii::import('application.extensions.phpmailer.JPhpMailer');
            if (empty($from))
                $from = NOREPLYMAIL;
            if (empty($fromName))
                $fromName = SITENAME;

            $mailer = new JPhpMailer;
            $mailer->IsSMTP();
            $mailer->IsHTML(true);
            $mailer->SMTPAuth = SMTPAUTH;
            $mailer->SMTPSecure = SMTPSECURE;
            $mailer->Host = SMTPHOST;
            $mailer->Port = SMTPPORT;
            $mailer->Username = SMTPUSERNAME;
            $mailer->Password = SMTPPASS;
            $mailer->From = $from;
            $mailer->FromName = $fromName;
            $mailer->AddAddress($to);
            // $mailer->

            $mailer->Subject = $subject;

            $mailer->MsgHTML($body);

            try {
                $mailer->Send();
            } catch (Exception $exc) {
                return $exc->getTraceAsString();
            }
        endif;
    }

    public function getMessage($body, &$translate) {
       
        if (EMAILLAYOUT == 'file'):
         
            $msg_header = file_get_contents(SITEURL . EMAILTEMPLATE . 'header.html');
            $msg_footer = file_get_contents(SITEURL . EMAILTEMPLATE . 'footer.html');  
            $msg_body = file_get_contents(SITEURL . EMAILTEMPLATE . $body . '.html');

            $message_dub = $msg_header . $msg_body . $msg_footer;

//        else: // for db concept
//            $msg_body = Mailtemplate::model()->find('id="' . $body . '"');
//
//            $message_dub = $msg_body->template_content;
         endif;

        $message = $this->translate($message_dub, $translate);
        return $message;
    }

    public function translate($msg_dub, $translate = array()) {
        $def_trans = array(
            "{SITEURL}" => SITEURL,
            "{SITENAME}" => SITENAME,
            "{EMAILHEADERIMAGE}" => Yii::app()->createAbsoluteUrl(EMAILHEADERIMAGE),
            "{CONTACTMAIL}" => CONTACTMAIL,
        );

        $translation = array_merge($def_trans, $translate);
        $message = strtr($msg_dub, $translation);

        return $message;
    }

    function sendPhpmail($to, $subject, $body, $attachment = null) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Additional headers
        $headers .= 'From: ' . SITENAME . ' <' . NOREPLYMAIL . '>' . "\r\n";

        mail($to, $subject, $body, $headers);
    }

}

?>