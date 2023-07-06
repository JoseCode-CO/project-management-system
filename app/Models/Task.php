<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "tasks";

    protected $fillable = [
        'title',
        'description',
        'status',
        'project_id',
        'created_by',
    ];

    public $timestamps = true;

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function project_id()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
