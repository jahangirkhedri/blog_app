<?php

namespace Blog\tests;

use App\Models\User;
use Blog\Models\Category;
use Blog\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */

    use RefreshDatabase;

    public function test_get_all_post()
    {
        Post::unguard();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/api/v1/posts');
        $response->assertStatus(200);

    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */

    public function test_create_post()
    {
        Post::unguard();
        Category::unguard();

        Category::create([
            'id' => 1,
            'title' => 'sport'
        ]);
        $user = User::factory()->create();
        $this->actingAs($user);
        $cat_data = [
            "id" => 2,
            "title" => "first post",
            "description" => "Loream ipsom is a unreal text.",
            "user_id" => 2,
            "created_at" => "2022-12-30T09:00:06.000000Z",
            "updated_at" => "2022-12-30T09:00:06.000000Z",

        ];
        $mock = \Mockery::mock('overload:Blog\Repository\PostRepository');
        $mock->shouldReceive('create')->once()
            ->andReturn(new Post($cat_data));

        $response = $this->post('/api/v1/posts', [
            "title" => "first post",
            "description" => "Loream ipsom is a unreal text.",
            "categories" => [1]
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            "success" => true,
            'data' => $cat_data,
            "message" => "Post created successfully."
        ]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */


    public function test_show_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        Post::unguard();
        $cat_data = [
            "id" => 2,
            "title" => "first post",
            "description" => "Loream ipsom is a unreal text.",
            "user_id" => 2,
            "created_at" => "2022-12-30T09:00:06.000000Z",
            "updated_at" => "2022-12-30T09:00:06.000000Z",

        ];
        $mock = \Mockery::mock('overload:Blog\Repository\PostRepository');
        $mock->shouldReceive('show')->once()
            ->andReturn(new Post($cat_data));
        $response = $this->get('api/v1/posts/2');
        $response->assertStatus(200);
        $response->assertJson([
            "success" => true,
            'data' => $cat_data,
            "message" => "Show post"
        ]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */


    public function test_update_post()
    {
        Category::unguard();
        Category::create([
            'id' => 1,
            'title' => 'sport'
        ]);
        $user = User::factory()->create();
        $this->actingAs($user);
        $cat_data = [
            "id" => 2,
            "title" => "first post",
            "description" => "Loream ipsom is a unreal text.",
            "user_id" => 2,
            "created_at" => "2022-12-30T09:00:06.000000Z",
            "updated_at" => "2022-12-30T09:00:06.000000Z",

        ];
        $mock = \Mockery::mock('overload:Blog\Repository\PostRepository');
        $mock->shouldReceive(['update' => true, 'show' => new Post($cat_data)])->once();

        $response = $this->patch('/api/v1/posts/1', [
            "title" => "first post",
            "description" => "Loream ipsom is a unreal text.",
            "categories" => [1]
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            "success" => true,
            'data' => $cat_data,
            "message" => "Post updated successfully."
        ]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */


    public function test_delete_post()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $mock = \Mockery::mock('overload:Blog\Repository\PostRepository');
        $mock->shouldReceive('delete')->once()
            ->andReturnTrue();

        $response = $this->delete('/api/v1/posts/1');

        $response->assertStatus(200);
        $response->assertJson([
            "success" => true,
            "data" => true,
            "message" => "Post deleted successfully."
        ]);

    }
}
