<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Etemplate extends Model
{
    protected $table = 'etemplates';
    protected $fillable = array( 'esender','emessage', 'smsapi');
}
