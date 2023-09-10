<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    public $incrementing = true;
    public $timestamps = true;
    protected $table = "addresses";
    protected $primaryKey = "id";
    protected $keyType = "int";

    protected $fillable = [
        'street',
        'city',
        'province',
        'country',
        'postal_code'
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, "contact_id", "id");
    }
}
