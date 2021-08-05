<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserTask extends Model
{
    use SoftDeletes;
    protected $table = 'user_task';
    protected $primaryKey='id';
   	public $timestamps = true;
    protected $fillable = [
        'user_id',
        'task_id',
        'status',
        'comment',
        'duration'
    ];
    public function task()
    {
        return $this->belongsTo(Task::class,'task_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
