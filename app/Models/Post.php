<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method create(array $array)
 */
class Post extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
