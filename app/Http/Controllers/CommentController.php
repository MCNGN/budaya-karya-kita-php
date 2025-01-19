<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    public function createComment(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'required|exists:forum,id',
            'comment' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        try {

            $comment = Comment::create([
                'post_id' => $request->post_id,
                'comment' => $request->comment,
                'user_id' => $request->user_id
            ]);

            return response()->json([
                'message' => 'Comment created successfully',
                'comment' => $comment,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getCommentsByPostId($id)
    {
        try {
            $comments = Comment::where('post_id', $id)
                ->with('user:id,username,profile')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($comments);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function updateComment(Request $request, $id)
    {
        $this->validate($request, [
            'comment' => 'required|string',
        ]);

        try {
            $comment = Comment::find($id);

            if (!$comment) {
                return response()->json(['error' => 'Comment not found'], 404);
            }

            $comment->update($request->all());

            return response()->json([
                'message' => 'Comment updated successfully',
                'comment' => $comment,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function deleteComment($id)
    {
        try {
            $comment = Comment::find($id);

            if (!$comment) {
                return response()->json(['error' => 'Comment not found'], 404);
            }

            $comment->delete();

            return response()->json(['message' => 'Comment deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function getCommentsList()
    {
        try {
            $comments = Comment::with('user:id,username,profile')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json($comments);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}