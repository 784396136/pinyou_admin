<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;

class TestController extends Controller
{
    public function index()
    {
        $data = Seller::where('id',3)->first();
        $transport = (new \Swift_SmtpTransport('smtp.126.com','25'))
                    ->setUsername('a784396136@126.com')
                    ->setPassword('w123456');
        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message('激活账号'))
        ->setFrom(['a784396136@126.com'=>'蕾姆'])
        ->setTo([$data->contact_email,$data->contact_email => $data->contact])
        ->setBody("恭喜您成功通过本站的审核,能在本站开点啦~");
        $mailer->send($message);
    }
}
