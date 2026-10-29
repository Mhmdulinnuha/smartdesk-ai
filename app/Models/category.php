<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class category extends Model
{
    use HasFactory;

    protected $fillable =[
        'nama',
        'slug',
        'description',
        'icon',
        'color',
    ];

    /**
     * @return HasMany<Ticket, $this>
     */

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * @return HasMany<KnowledgeArticle, $this>
     */
    
    public function articles(): HasMany
    {
        return $this->hasMany(KnowledgeArticle::class);
    }
}
