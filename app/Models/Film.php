<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;


class Film extends Model 
{
    use  HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'format', 
        'age_rating',
        'duration',
        'subtitles',
    
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
         'created_at',
         'updated_at'
    ];


   /**
     * Polimorphic relation to obteins the specific item
     */
    public function item(): MorphOne {
        return $this->morphOne(Item::class,'itemable');
    }
}
