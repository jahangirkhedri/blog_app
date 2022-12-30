<?php

namespace Blog\tests;

use App\Models\User;
use Blog\Models\Category;
use Blog\Models\Post;
use Blog\Repository\PostRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */

    use RefreshDatabase;

    public function test_create_post()
    {
        User::unguard();
        User::create([
            'id' => 1,
            'name' => 'jahangir',
            'email' => 'jahan@gmail.com',
            'password' => bcrypt(123456)
        ]);
        $data = [
            'title' => 'IT',
            'description' => 'Loream ipsum is a text for test.',
            'user_id' => 1
        ];
        $post = new PostRepository(new Post());
        $post->create($data);

        $this->assertDatabaseHas('posts', $data);

    }

    public function test_show_post()
    {
        User::unguard();
        User::create([
            'id' => 1,
            'name' => 'jahangir',
            'email' => 'jahan@gmail.com',
            'password' => bcrypt(123456)
        ]);
        $data = Post::create([
            'title' => 'IT',
            'description' => 'Loream ipsum is a text for test.',
            'user_id' => 1
        ])->toArray();
        $post = new PostRepository(new Post());
        $response = $post->show($data['id']);
        $this->assertEquals($data, $response->toArray());
    }

    public function test_update_category()
    {

        Post::unguard();
        User::create([
            'id' => 1,
            'name' => 'jahangir',
            'email' => 'jahan@gmail.com',
            'password' => bcrypt(123456)
        ]);
        Category::unguard();
        Category::create([
            'id' => 1,
            'title' => 'sport'
        ]);

        User::unguard();
        $data = Post::create([
            'id' => 1,
            'title' => 'first post',
            'description' => 'Loream ipsum is a text for test.',
            'user_id' => 1
        ])->toArray();

        $post = new PostRepository(new Post());
        $newData = [
            'title' => 'first post edited',
            'description' => 'Loream ipsum is a text for test.',
            'user_id' => 1,
            'categories' => [1]
        ];
        $response = $post->update($newData, 1);
        $this->assertEquals($newData['title'], $response->toArray()['title']);

    }

    public function test_delete_post()
    {
        User::unguard();
        User::create([
            'id' => 1,
            'name' => 'jahangir',
            'email' => 'jahan@gmail.com',
            'password' => bcrypt(123456)
        ]);
        Post::unguard();
        $data = Post::create([
            'id' => 1,
            'title' => 'first post',
            'description' => 'Loream ipsum is a text for test.',
            'user_id' => 1
        ])->toArray();
        $category = new PostRepository(new Post());
        $response = $category->delete(1);
        $this->assertEquals(1, $response);
        $this->assertDatabaseMissing('posts', $data);
    }
}
