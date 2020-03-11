<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Group\Group;
use App\Model\Group\Reply;
use App\Model\Group\Post;
use App\Model\Group\Like;
use Auth;
class GroupController extends Controller
{
    public function showGroups()
    {
        $groups = Group::getAllGroups();
        return response()->json($groups,200) ;
    }

    public function showPosts($id)
    {
        $posts = Post::getPostsByGroupId($id);
        return response()->json($posts,200);
    }

    public function addPost(Request $request)
    {
        $fetchedData = $request->all();
        $this->validate($request,[
            'text'     => 'required',
            'group_id' => 'required'
        ]);

        $postCreated = Post::create([
            'text'      => $fetchedData['text'],
            'group_id'  => $fetchedData['group_id'],
            'user_id'   => Auth::User()->id
        ])->wasRecentlyCreated;

        if($postCreated)
        {
            return response()->json(["massage"=>"Store Successfully"],200);
        }
        else
        {
            return response()->json(["massage"=>"Failed to Store"],400);
        }
    }

    public function showReplies($id)
    {
        $replies = Reply::getRepliesByPostId($id);
        return response()->json($replies,200);
    }

    public function addReply(Request $request)
    {
        $fetchedData = $request->all();
        $this->validate($request,[
            'text'     => 'required',
            'post_id' => 'required'
        ]);

        $replyCreated = Reply::create([
            'text'     => $fetchedData['text'   ],
            'post_id'  => $fetchedData['post_id'],
            'user_id'  => Auth::User()->id
        ])->wasRecentlyCreated;

        if($replyCreated)
        {
            return response()->json(["massage"=>"Store Successfully"],200);
        }
        else
        {
            return response()->json(["massage"=>"Failed to Store"],400);
        }
    }

    public function addLike(Request $request)
    {
        $fetchedData = $request->all();
        $this->validate($request,[
            'reply_id' => 'required',
            'post_id'  => 'required'
        ]);

        $likeCreated = Like::create([
            'reply_id' => $fetchedData['reply_id'],
            'post_id'  => $fetchedData['post_id'],
            'user_id'  => Auth::User()->id
        ])->wasRecentlyCreated;

        if($likeCreated)
        {
            return response()->json(["massage"=>"Store Successfully"],200);
        }
        else
        {
            return response()->json(["massage"=>"Failed to Store"],400);
        }
    }

}
