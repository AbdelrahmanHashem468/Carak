<?php

namespace App\Model\Group;

use Illuminate\Database\Eloquent\Model;
use App\Model\Group\Reply;

class Like extends Model
{
    Protected $guarded = [];

    public function reply()
    {
        return $this->belongsTo(Reply::class);
    }
}
