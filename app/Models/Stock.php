<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'quantite',
        'created_at',
        'updated_at',
    ];
    public function appareils()
    {
        return $this->hasMany(Appareil::class);
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
