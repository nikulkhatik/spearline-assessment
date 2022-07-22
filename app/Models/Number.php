<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    use HasFactory;

    protected $table = 'number';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'number',
        'country_code_id',
    ];

    public function countryCode(){
        return $this->hasOne('App\Models\CountryCode', 'id', 'country_code_id');
    }

    public function company(){
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }
}
