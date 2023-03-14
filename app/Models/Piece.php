<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Piece extends Model implements HasMedia
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;
    use HasProfilePhoto;

    protected $fillable = [
        'title',
        'num_serie',
        'made_in',
        'price',
        'icons',
        'created_at',
        'updated_at',
    ];

    public function interventions()
    {
        return $this->belongsToMany(Intervention::class);
    }

    public function userCreated()
    {
        return $this->belongsTo(User::class);
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class);
    }
}
