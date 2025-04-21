<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'projects'; // table name
    protected $primaryKey = 'id'; // primary key column name
    protected $fillable = [
        'name',
        'code',
        'description',
        'notes',
        'start_date',
        'end_date',
        'estimate_type',
        'billable_rate_type',
        'rate',
        'fixed_fee',
        'budget_type',
        'budget_amount',
        'budget_reset',
        'alert_percentage',
        'average_hours',
        'estimate',
        'description'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id'); // 'project_id' is the foreign key in the tasks table
    }

    public function client()
{
    return $this->belongsTo(Client::class);
}

public function project()
{
    return $this->belongsTo(Job::class);
}

public function proposals()
{
    return $this->belongsToMany(Proposal::class, 'project_proposal');
}

}