<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','title','status'];

    public function index(){
        return auth()
        ->user()
        ->TaskList
        ->sortBy("status");
    }

    public function create($fields)
    {
        return auth()->user()->taskList()->create($fields);
    }

    public function show($id)
    {
        $show = auth()->user()->taskList()->find($id);

        if (!$show) {
            throw new \Exception('Nada Encontrado', -404);
        }

        return $show;

    }

    public function updateList($fields, $id)
    {
        $tasklist = $this->show($id);

        $tasklist->update($fields);
        return $tasklist;
    }

    public function destroyList($id)
    {
        $tasklist = $this->show($id);

        $tasklist->delete();
        return $tasklist;
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    
    public function tasks(){
        return $this->hasMany('App\Models\Tasks');
    }
}
