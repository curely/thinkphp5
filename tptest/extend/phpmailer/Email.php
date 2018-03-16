<?php
/**
 * 发送邮件类库
 */
namespace phpmailer;
use think\Exception;

class Email {
    /**
     * @param $to
     * @param $title
     * @param $content
     * @return bool
     */
    public  static function send($to, $title, $content) {
        date_default_timezone_set('PRC');//set time
        if(empty($to)) {
            return false;
        }
        try {
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Debugoutput = 'html';
            //Set the hostname of the mail server
            $mail->Host = config('email.host');// 服务器地址
            //Set the SMTP port number - likely to be 25, 465 or 587
            $mail->Port = config('email.port');// 端口
            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;
            //Username to use for SMTP authentication
            $mail->Username = config('email.username');// SMTP 用户名（你要使用的邮件发送账号）
            //Password to use for SMTP authentication
            $mail->Password = config('email.password');// SMTP 密码
            //Set who the message is to be sent from
            $mail->setFrom(config('email.username'), 'TP5');// 来自收件人
            //Set an alternative reply-to address
            //$mail->addReplyTo('replyto@example.com', 'First Last');
            //Set who the message is to be sent to
            $mail->addAddress($to);// 添加一个收件人
            //Set the subject line
            $mail->Subject = $title;//邮件标题
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML($content);//邮件内容
            //Replace the plain text body with one created manually
            //$mail->AltBody = 'This is a plain-text message body';
            //Attach an image file
            //$mail->addAttachment('images/phpmailer_mini.png');

            //send the message, check for errors
            if (!$mail->send()) {
                return false;
                //echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                return true;
            }
        }catch(phpmailerException $e) {
            return false;
        }
    }
}