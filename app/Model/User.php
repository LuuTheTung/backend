<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Validation\Rule;
class User extends Authenticatable
{
    use Notifiable;
    public $table = 'user';
    
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'mst_company_id', 
        'family_name',
        'given_name',
        'email',
        'password',
        'phone_number',
        'address',
        'state_flg',
        'start_work_date',
        'end_work_date',
        'user_flg',
        'create_user',
        'update_user'
    ];

    protected $casts = [
        'mst_company_id' => 'integer',
        'family_name' => 'string',
        'given_name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'phone_number' => 'string',
        'address' => 'string',
        'state_flg' => 'integer',
        'start_work_date' => 'string',
        'end_work_date' => 'string',
        'user_flg' => 'integer',
        'create_at' => 'datetime',
        'create_user' => 'string',
        'update_at' => 'datetime',
        'update_user' => 'string'
    ];

    public function rules($id = "", $checkEmailUniq = true, $checkPhoneUniq = true){
        $rules = [          
            'family_name' => 'required',
            'given_name' => 'required',
            'password' => 'required',
        ];

        if($checkEmailUniq){
            $rules['email'] = ['required',
                    'email',
                    Rule::unique($this->table)->ignore($id),
            ];
        }else{
            $rules['email'] = 'required|email';
        }

        if($checkPhoneUniq){
            $rules['phone_number'] = ['required',
                    'numeric',
                    Rule::unique($this->table)->ignore($id),
            ];
        }else{
            $rules['phone_number'] = 'required|numeric';
        }
        
        return $rules;
    }
}
