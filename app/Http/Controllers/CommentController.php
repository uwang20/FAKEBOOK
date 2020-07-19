<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;

class CommentController extends Controller
{
    public function postComment(Post $post){
      $addedComment = $post->comments()->create(request()->all());

      $commentByName = User::find($addedComment->comment_by)->first_name. ' ' .User::find($addedComment->comment_by)->last_name;

      $modifiedAddedComment = collect($addedComment)->merge([
        'name' => $commentByName
      ]);

      return response()->json($modifiedAddedComment);
    }
}
