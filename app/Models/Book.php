<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	protected $fillable = ['title', 'quantity', 'image'];

    public function authors()    {
       return $this->belongsToMany('App\Models\Author', 'books_authors');
    }
}
