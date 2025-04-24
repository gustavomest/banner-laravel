<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'platform',
        'campaign',
        'resolution',
        'weight',
        'time',
        'format',
        'company',
        'type',
        'file_path',
        'task_id',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    
}
