<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\HarvestService;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients'; // table name
    protected $primaryKey = 'id'; // primary key column name
    protected $fillable = [
        'name',
        'email',
        'phone',
        'add1',
        'add2',
        'city',
        'state',
        'zip',
        'website',
        'logo',
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
    
        public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function project()
    {
        return $this->belongsTo(Job::class);
    }
}
