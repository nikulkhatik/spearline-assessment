<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobProcessingEcho extends Model
{
    use HasFactory;

    protected $table = 'job_processing_echo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'test_type_id',
        'job_id',
        'number_id',
        'call_start_time',
        'call_connect_time',
        'call_end_time',
        'call_description_id',
        'created_on',
        'updated_on',
    ];

    public function job(){
        return $this->hasOne('App\Models\Job', 'id', 'job_id');
    }

    public function number(){
        return $this->hasOne('App\Models\Number', 'id', 'number_id');
    }

    public function company(){
        return $this->hasOneThrough(
            'App\Models\Company',
            'App\Models\Job',
            'id',
            'id',
            'job_id',
            'company_id'
        );
    }

    public function country(){
        return $this->hasOneThrough(
            'App\Models\CountryCode',
            'App\Models\Number',
            'id',
            'id',
            'number_id',
            'country_code_id'
        );
    }
}
