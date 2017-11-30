<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    protected $fillable = ['body'];

    // author attribútum
    public function getAuthorAttribute () {
        return User::find($this->user_id);
    }

    // save metódus felülírása
    // user_id beállítása létrehozáskor
    public function save (array $params = []) {
        if (!$this->user_id) $this->user_id = Auth::user()->id;
        parent::save();
    }
}
