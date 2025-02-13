<?php

namespace App\Models{
    use Illuminate\Database\Eloquent\Model;

    class Task extends Model{

        protected $table = "tasks";
        protected $fillable = [
            "name_task"
            ,"description_task"
            ,"complete"
            ,"actived"
            ,"created_at"
            ,"updated_at"
        ];
    }
}

