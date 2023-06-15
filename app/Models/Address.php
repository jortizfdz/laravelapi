<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Address extends Model
{
    use HasFactory, SoftDeletes;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'addresses';
    protected $guarded = [];

    public function libraries(): HasMany
    {
      return $this->hasMany(Library::class);
    }
    public function editorials(): HasMany
    {
      return $this->hasMany(Editorial::class);
    }
}
