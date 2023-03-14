<?php

namespace App\Models;

use App\Models\Appareil;
use App\Models\Intervention;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Panne extends Model
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'appareil_id',
        'intervention_id',
        'created_at',
        'updated_at',
    ];
    public function interventions()
    {
        return $this->belongsTo(Intervention::class);
    }
    public function appareil()
    {
        return $this->belongsTo(Appareil::class);
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
