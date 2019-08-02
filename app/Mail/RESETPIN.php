<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\EmailHelper;

class RESETPIN extends Mailable
{
    use Queueable, SerializesModels;

   public $user;
   public $str;
   public $body;
    public function __construct($user,$str)
    {
        $this->user=$user;
        $this->str=$str;
        $cont='<p>'.$user->name.' your request for change pin taken under consideration</p>';
        $this->body=$this->layout($cont);
    }

    public function layout($content){
        $body = "";
        $body .= EmailHelper::getEmailHeader();
        $body .= $content;
        $body .= EmailHelper::getEmailFooter();
        return $body;
    }
    public function build()
    {
        return $this->subject('RESET PIN')
                    ->view('resetpin')
                    ->with(
                        [
                            'html'=>$this->body,
                        ]
                    );
    }
}
