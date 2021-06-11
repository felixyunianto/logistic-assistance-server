<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bencana extends Model
{
    protected $guarded = [];

    protected $hidden = ['public_id_image'];
}
