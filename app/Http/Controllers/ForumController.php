<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;

class ForumController extends Controller
{
    public function createPost(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        try {
            $forum = Forum::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $request->user()->id,
            ]);

            return response()->json($forum, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getPosts()
    {
        try {
            $forums = Forum::all();
            return response()->json($forums);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getPostById($id)
    {
        try {
            $forum = Forum::find($id);

            if (!$forum) {
                return response()->json(['error' => 'Post not found'], 404);
            }

            return response()->json($forum);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function updatePost(Request $request, $id)
    {
        try {
            $forum = Forum::find($id);

            if (!$forum) {
                return response()->json(['error' => 'Post not found'], 404);
            }

            $forum->update($request->all());

            return response()->json(['message' => 'Post updated successfully', 'post' => $forum]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function deletePost($id)
    {
        try {
            $forum = Forum::find($id);

            if (!$forum) {
                return response()->json(['error' => 'Post not found'], 404);
            }

            $forum->delete();

            return response()->json(['message' => 'Post deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}