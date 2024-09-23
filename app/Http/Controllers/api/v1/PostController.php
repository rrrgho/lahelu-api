<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

/**
 * @OA\Schema(
 *     schema="PostWithUser",
 *     type="object",
 *     properties={
 *         @OA\Property(property="id", type="string", format="uuid", example="c4751f00-c2fb-be34-5197-6bb66de09faf"),
 *         @OA\Property(property="user_id", type="string", format="uuid"),
 *         @OA\Property(property="caption", type="string", example="24. Impedit quia quo voluptatum sed corrupti."),
 *         @OA\Property(property="image", type="string", format="uri", example="https://cache.lahelu.com/image-PTXnhEi57-22113"),
 *         @OA\Property(property="video", type="string"),
 *         @OA\Property(property="like", type="integer", example=34),
 *         @OA\Property(property="unlike", type="integer", example=3),
 *         @OA\Property(property="is_sensitive", type="boolean", example=true),
 *         @OA\Property(property="is_onrule", type="boolean", example=true),
 *         @OA\Property(property="created_at", type="string", format="date-time"),
 *         @OA\Property(property="updated_at", type="string", format="date-time"),   

 *         @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true),
 *         @OA\Property(property="user",   type="object", ref="#/components/schemas/User") 
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="CommentWithUser",
 *     type="object",
 *     properties={
 *         @OA\Property(property="id", type="integer", example=79),
 *         @OA\Property(property="user_id", type="string", format="uuid", example="dbecd449-e7a2-315a-a38a-348b2e38e516"),
 *         @OA\Property(property="post_id", type="string", format="uuid", example="55e038cd-87e5-9be4-2aad-8cfcb3867915"),
 *         @OA\Property(property="comment_id", type="integer", nullable=true), 
 *         @OA\Property(property="comment", type="string", example="This is a comment."),
 *         @OA\Property(property="video", type="string", nullable=true),
 *         @OA\Property(property="likes", type="integer", example=1),
 *         @OA\Property(property="created_at", type="string", format="date-time"),
 *         @OA\Property(property="updated_at", type="string", format="date-time"),
 *         @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true),
 *         @OA\Property(property="user", type="object", ref="#/components/schemas/User")
 *     }
 * )
 */

class PostController extends Controller
{
    /**
     * @OA\Get(
     *     path="api/v1/posts",
     *     summary="Get paginated posts with their associated user",
     *     tags={"Meme Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PostWithUser")   

     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            $posts = Post::with('user')->inRandomOrder()->limit(2)->get();

            return response()->json($posts, 200);

        } catch (\Exception $e) {
            Log::error('Error fetching posts: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while retrieving posts.'
            ], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="api/v1/comments",
     *     summary="Get comments for a post with their associated user",
     *     tags={"Meme Posts"},
     *     @OA\Parameter(
     *         name="post_id",
     *         in="query",
     *         description="ID of the post to get comments for",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/CommentWithUser")   

     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function comment(Request $request){
        try {
            $comment = Comment::with('user')->where('post_id', $request->query('post_id'))->get();
            // $comment = Comment::with('user')->get()->take(2);

            return response()->json($comment, 200);

        } catch (\Exception $e) {
            Log::error('Error fetching posts: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while retrieving posts.'
            ], 500);
        }
    }
}
