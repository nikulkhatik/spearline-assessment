<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryCode extends Model
{
    use HasFactory;

    protected $table = 'country_code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'country_code',
        'country_name',
        'country_prefix',
    ];

    public function number(){
        return $this->hasMany('App\Models\Number', 'country_code_id', 'id');
    }
}
