<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Editorial extends Model
{
    use HasFactory, SoftDeletes;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'editorials';
    protected $guarded = [];

    public function books(): HasMany
    {
      return $this->hasMany(Book::class);
    }

    public function address(): BelongsTo
    {
         return $this->belongsTo(Address::class);
    }

    public function authors(): HasMany
    {
      return $this->hasMany(Author::class);
    }
}
