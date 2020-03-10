<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Group\Group;
use App\Model\Group\Post;
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
}
