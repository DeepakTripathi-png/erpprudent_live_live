<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'PHPMailerAutoload.php';
Class Mail
{
	protected $CI;
	function __construct()
  {
    $this->CI =&get_instance();  
  }

  function send($to,$subject,$msg,$attach=false)
  {  
      $this->CI->config->load('email', TRUE);
      $email_setting=$this->CI->config->item('email');
      $live=$email_setting['mode'];
      $prevent=$email_setting['prevent'];

      if($live)
      {$email_config =$email_setting['live'];}
      else
      {$email_config =$email_setting['development'];}
      
      if(isset($to)&&isset($subject)&& isset($msg)&&!($prevent))
      {
        date_default_timezone_set('Etc/UTC');
        
        $mail = new PHPMailer();
	      $mail->isSMTP();
        $mail->SMTPDebug  	= 0;                    
        $mail->Debugoutput	= 'html';
        $mail->Host         = $email_config['Host'];      
        $mail->Port         = $email_config['Port'];                   
        $mail->SMTPSecure   = $email_config['SMTPSecure'];                 
        $mail->SMTPAuth     = $email_config['SMTPAuth'];                  
        $mail->Username     = $email_config['Username']; 
        $mail->Password     = $email_config['Password'];
        $mail->SetFrom($email_config['from_email'], $email_config['from_name']);
        $mail->AddReplyTo($email_config['reply_to'],$email_config['reply_name']);
	      $mail->Subject    	= $subject;
        $mail->AltBody    	= "";
        $body=$msg;
        $mail->MsgHTML($body);
        $mail->addAddress($to);
        $attchmentDir=$email_setting['attchmentDir'];
        if($attach)
        {
            for($j=0;$j<count($attach);$j++)
            {
               $mail->addAttachment($attchmentDir.$attach[$j]);
            }
        }

        if(!$mail->Send())
          {return false;} 
        else
          {return true;}
      }
      else{return false;} 
    }	
}