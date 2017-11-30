<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'body'];

    // author attribútum
    public function getAuthorAttribute () {
        return User::find($this->user_id);
    }

    // comments attribútum
    public function getCommentsAttribute () {
        return Comment::where('post_id', $this->id)->get();
    }

    // save metódus felülírása
    // slug beállítása mentéskor, user_id beállítása létrehozáskor
    public function save (array $params = []) {
        $this->slug = Str::slug($this->title);
        if (!$this->user_id) $this->user_id = Auth::user()->id;
        parent::save();
    }

    // delete metódus felülírása
    // a post-hoz tartozó comment-ek is törlésre kerülnek
    public function delete () {
        foreach (Comment::where('post_id', $this->id)->get() as $comment) {
            $comment->delete();
        }
        parent::delete();
    }


}
