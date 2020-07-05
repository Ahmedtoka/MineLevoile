<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable =[

        "name", "parent_id", "is_active"
    ];

    public function product()
    {
    	return $this->hasMany('App\Product');
    }

    public function getParent($id)
    {
    	$parent  = $this->where('id', $id)->first();
    	
    	return $parent->name;
    }
}
