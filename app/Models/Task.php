<?php

namespace App\Models;

use App\Exceptions\ControllerException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'done'];

    public static function createTask(array $data, Checklist $checklist)
    {
        if($checklist->tasks()->count() >=30){
            throw new ControllerException('Count of tasks more than 30', 404);
        }
        $task = new Task($data);
        $task->checklist()->associate($checklist);
        $task->save();
        return $task;
    }

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function deleteTask()
    {
        $this->delete();
    }

    public function updateTask(array $data)
    {
        $this->update($data);
        return $this;
    }
}
