<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reserved_at',
        'duration',
        'status',
        'resources_id'
    ];
    
    public $timestamps = false;

/**
 * @return A relationship is being defined in this code snippet. The `resource()` function is returning
 * a belongsTo relationship with the `Resource` model. It specifies that the current model belongs to
 * the `Resource` model using the foreign key `resources_id` in the current model and the primary key
 * `id` in the `Resource` model.
 */
    public function resource()
    {
        return $this->belongsTo(Resource::class, 'resources_id', 'id');
    }
}
