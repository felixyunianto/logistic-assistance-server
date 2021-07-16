<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Posko;

class PenerimaanLogistik extends Model
{
    protected $guarded = [];

    public function posko(){
        return $this->belongsTo(Posko::class, 'id_posko');
    }
}
