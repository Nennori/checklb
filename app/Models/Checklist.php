<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function updateChecklist(array $data)
    {
        $this->update($data);
        return $this;
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createChecklist(array $data, User $user)
    {
        $checklist = new Checklist($data);
        $checklist->user()->associate($user);
        $checklist->save();
        return $checklist;
    }

    public function deleteChecklist()
    {
        $this->delete();
    }
}
