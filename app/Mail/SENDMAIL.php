<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SENDMAIL extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $num;
    public $type;
    public function __construct($num,$type)
    {
        $this->num=$num;
        $this->type=$type;
    }

   
    public function build()
    {
        if($type='Primary Email'){
            return $this->from('matulcste@gmail.com')
                ->view('master_backend.codeconfirm');
        }else{
            return $this->from('matulcste@gmail.com')
                ->view('master_backend.codeconfirmsecond');
        }
        
    }
}
