<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    // GET /posts/{post}/comments
    public function index(Post $post)
    {
        $comments = Comment::where('post_id', $post->id)->paginate(config('developro.paginator.comments'));
        foreach ($comments as &$c) {
            $c->author = $c->author;
        }
        return $comments;
    }

    // POST /posts/{post}/comments
    public function create(Request $request, Post $post)
    {
        $v = Validator::make($request->all(), $this->getRules());
        if ($v->fails()) {
            return response()->json($v->messages(), 500);
        }

        $comment = new Comment();
        $comment->body = $request->get('body');
        $comment->post_id = $post->id;
        $comment->save();

        return response()->json($post, 201);
    }

    // DELETE /posts/{post}/comments/{comment}
    public function delete(Post $post, Comment $comment)
    {
        $comment->delete();
        return response()->json(null, 204);
    }

    private function getRules () {
        return [
            'body' => 'required'
        ];
    }
}
