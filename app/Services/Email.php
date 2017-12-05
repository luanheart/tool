<?php
/**
 * Created by PhpStorm.
 * User: xujin
 * Date: 2017/12/4
 * Time: 下午5:39
 */

namespace App\Services;


class Email
{
    public static function send($subject, $content, $to = [])
    {
        $subject = 'TOOL ' . $subject;

        \Mail::send('email.text', ['content' => $content], function ($message) use ($subject, $to){
            if (is_array($to)){
                if ($to){
                    foreach ($to as $email){
                        $message->to($email);
                    }
                }else{
                    $message->to(config('mail.from.address'));
                }
            }else{
                $message->to($to);
            }
            $message->subject($subject);
        });
    }
}