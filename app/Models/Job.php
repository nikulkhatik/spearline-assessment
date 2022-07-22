<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'test_type_id',
        'name',
        'start_time',
    ];

    public function company(){
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }

    public function testType(){
        return $this->hasOne('App\Models\TestType', 'id', 'test_type_id');
    }

    public function jobProcessing(){
        return $this->hasMany('App\Models\JobProcessing', 'job_id', 'id');
    }

    public function jobProcessingEcho(){
        return $this->hasMany('App\Models\JobProcessingEcho', 'job_id', 'id');
    }

    public function jobProcessingFailover(){
        return $this->hasMany('App\Models\JobProcessingFailover', 'job_id', 'id');
    }
}
