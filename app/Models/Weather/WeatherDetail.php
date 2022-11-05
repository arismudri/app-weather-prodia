<?php

namespace App\Models\Weather;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WeatherDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "weather_id",
        "weather_detail_id",
        "main",
        "description",
    ];

    /**
     * The "boot" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();


        self::creating(function ($model) {
            $user = Auth::user();
            $model->created_by = $user->id ?? null;
            $model->updated_by = $user->id ?? null;
        });

        static::updating(function ($model) {
            $user = Auth::user();
            $model->updated_by = $user->id ?? null;
        });

        static::deleting(function ($model) {
            $user = Auth::user();
            $model->deleted_by = $user->id ?? null;
        });
    }

    /**
     * Get the weather of the detail.
     */
    public function weather()
    {
        return $this->belongsTo(Weather::class);
    }
}
