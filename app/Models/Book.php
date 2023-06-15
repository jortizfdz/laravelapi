<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory, SoftDeletes;
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'books';
    protected $guarded = [];

    public function editorial(): BelongsTo
    {
         return $this->belongsTo(Editorial::class);
    }

    public function author(): BelongsTo
    {
         return $this->belongsTo(Author::class);
    }

    public function libraries(): BelongsToMany
     {
         return $this->belongsToMany(Library::class,'libraries_books','book_id','library_id');
     }
}
