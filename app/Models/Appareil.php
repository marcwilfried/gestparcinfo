<?php

namespace App\Models;

use App\Models\User;
use Components\Card;
use App\Models\Stock;
use Components\Button;
use App\Models\Logiciel;
use App\Models\Service;;
use Components\TableColumn;
use App\Models\TypeAppareil;
use App\Models\Caracteristique;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Filament\Resources\StockResource;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;



class Appareil extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'marque',
        'num_serie',
        'etat',
        'disponibilite',
        'stock_id',
        'type_appareil_id',
        'service_id',
        'created_at',
        'updated_at',
        'image',
    ];

    /*  public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
        ->width(368)
        ->height(232)
        ->sharpen(10);

        $this->addMediaConversion('normal')
        ->width(800)
        ->height(800);

        $this->addMediaConversion('conversion')
        ->quality(80)
        ->withResponsiveImages();
    } */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
    public function caracteristiques()
    {
        return $this->belongsToMany(Caracteristique::class);
    }
    public function logiciels()
    {
        return $this->belongsToMany(Logiciel::class);
    }
    public function type_appareil()
    {
        return $this->belongsTo(TypeAppareil::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pannes()
    {
        return $this->hasMany(Panne::class);
    }

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
