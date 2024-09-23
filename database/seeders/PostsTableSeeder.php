<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users and tags
        $users = User::all();
        $tags = Tag::all();

        // Each user has 3 posts
        $users->each(function ($user) use ($tags) {
            $posts = Post::factory()->count(3)->for($user)->create();

            // Each post should be related to 2 tags
            $posts->each(function ($post) use ($tags, $user) {
                // Debugging: Check if UUIDs are correct
                dump($post->id); // Should output a valid UUID
                dump($tags->random(2)->pluck('id')->toArray()); // Should be UUIDs

                
                // Attach 2 random tags to the post
                $post->tags()->attach($tags->random(2)->pluck('id')->toArray());


                // Exclude the post owner from comments
                $otherUsers = User::where('id', '!=', $user->id)->get();

                // Add 9 comments to the post from other users
                $otherUsers->random(9)->each(function ($commenter) use ($post) {
                    $comment = $commenter->comments()->create([
                        'post_id' => $post->id,
                        'comment' => 'This is a comment.',
                        'likes' => random_int(0, 50),
                    ]);
                });
            });
        });
    }
}
