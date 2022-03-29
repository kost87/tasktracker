<?php

namespace App\Models;

use App\Models\User;
use App\Models\Status;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public const FINISHED_STATUS = "Завершена";
    protected $fillable = ['user_id', 'title', 'content', 'deadline', 'date_done', 'status_id'];

    public $expired;  //задача просрочена
    public $finished; //задача завершена

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
