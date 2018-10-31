<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class MailController extends Controller
{
    public function send($title,$email,$name,$mes)
    {
        $transport = (new \Swift_SmtpTransport('smtp.126.com','25'))
                    ->setUsername('a784396136@126.com')
                    ->setPassword('w123456');
        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message($title))
        ->setFrom(['a784396136@126.com'=>'蕾姆'])
        ->setTo([$res->contact_email,$res->contact_email => $res->contact])
        ->setBody($data['reason'],'text/html');
        $mailer->send($message);
    }
}
