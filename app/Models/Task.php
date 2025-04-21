<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', // Foreign key to the projects table
        'name',
        'rate',
    ];

    // Define the inverse relationship with the Job model
    public function project()
    {
        return $this->belongsTo(Job::class, 'project_id');
    }
}