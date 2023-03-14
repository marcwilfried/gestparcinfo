<?php

namespace App\Models;

use App\Models\User;
use App\Models\Panne;
use App\Models\Piece;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Intervention extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;
    protected $fillable = [
        'title',
        'description',
        'motif',
        'date_intervention',
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function pieces()
    {
        return $this->belongsToMany(Piece::class);
    }

    public function pannes()
    {
        return $this->hasMany(Panne::class);
    }

    public function appareils()
    {
        return $this->belongsToMany(Appareil::class);
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
