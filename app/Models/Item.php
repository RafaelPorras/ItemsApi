<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Item extends Model 
{
    use  HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title', 
        'description',
        'owner',
        'language',
        'adquisition_date',
        'status',
        'publication_year',
        'collection',
        'author_id',
        'editorial_id',
        'genre_id',
        'category_id',
        'itemable_id',
        'itemable_type',
    
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
    public function itemable() : MorphTo {
        return $this->morphTo();
    }
}
