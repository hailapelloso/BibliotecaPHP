<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
	protected $fillable = ['user_id', 'start_date', 'end_date', 'devolution_date'];

    public function books()    {
       return $this->belongsToMany('App\Models\Book', 'books_loans');
    }
}
