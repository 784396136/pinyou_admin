<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    public function send($title,$email,$name,$mes)
    {
        $transport = (new \Swift_SmtpTransport('smtp.126.com','25'))
                    ->setUsername('a784396136@126.com')
                    ->setPassword('w123456');
        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message($title))
        ->setFrom(['a784396136@126.com'=>'蕾姆'])
        ->setTo([$email,$email => $name])
        ->setBody($mes,'text/html');

        return $mailer->send($message);
    }  
}
