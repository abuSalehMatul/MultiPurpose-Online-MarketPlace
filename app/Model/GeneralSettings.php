<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GeneralSettings extends Model
{
        public $timestamps = false;

    protected $table = 'basic_settings';

    protected $guarded = [];

}
