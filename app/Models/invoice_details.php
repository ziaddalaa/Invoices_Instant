<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice_details extends Model
{
    protected $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(sections::class);
    }

    use HasFactory;
}
