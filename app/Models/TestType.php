<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'test_type',
        'description',
        'job_processing_table',
    ];

    public function testType(){
        return $this->hasMany('App\Models\Job', 'test_type_id', 'id');
    }
}
