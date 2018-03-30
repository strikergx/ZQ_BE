<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function email(Request $request)
    {
        $User = new User();
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code = $code . rand(0, 9);
        }
        $data = ['email' => $request->json('email'), 'code' => $code];
        //这里就要入库 进行验证 验证注册的captcha 密码找回验证找回的captcha

        Mail::send('emails', $data, function ($message) use ($data) {
            $message->to($data['email'])->subject('欢迎注册我们的网站，请查收验证码！');
        });

        $res = $User -> RegSendCaptcha($data);

        if($res == -1) {
            return response() -> json(['code' => -1, 'msg' => '用户名已经存在']);
        } else {
            return response() -> json(['code' => 0, 'msg' => $code]);
        }

    }
}
