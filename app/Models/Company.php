<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function number(){
        return $this->hasOne('App\Models\Number', 'company_id', 'id');
    }

    public function job(){
        return $this->hasMany('App\Models\Job', 'company_id', 'id');
    }
}
