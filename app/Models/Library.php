<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Library extends Model
{
    use HasFactory, SoftDeletes;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'libraries';
    protected $guarded = [];

    public function address(): BelongsTo
    {
         return $this->belongsTo(Address::class);
    }

    public function books(): BelongsToMany
     {
         return $this->belongsToMany(Book::class,'libraries_books','library_id','book_id');
     }

}
