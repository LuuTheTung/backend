<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
class Category extends Model
{
    public $table = 'category';

    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';

    public $fillable = [];
  
    public function rules(){
        $rules = [          
            'category_name' => 'required',
            'type' => 'required',
            'price' => 'numeric',
            'sale_off' => 'numeric',
        ];
        
        return $rules;
    }

}
