<?php

namespace Blog\tests;

use App\Models\User;
use Blog\Models\Category;
use Blog\Repository\CategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Mockery\MockInterface;
use Repository\Repository;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */

    use RefreshDatabase;
    public function test_create_category()
    {
        Category::unguard();
        $user = User::factory()->create();
        $this->actingAs($user);

        $cat_data = [
            'id' => 1,
            'title' => 'tech'
        ];

        $mock = \Mockery::mock('overload:Blog\Repository\CategoryRepository');
        $mock->shouldReceive('create')
            ->once()
            ->andReturn(new Category([
                'id' => 1,
                'title' => 'tech'
            ]));

        $response = $this->post('/api/v1/categories', [
            'title' => 'tech'
        ]);
        $this->assertEquals('tech', $response['data']['title']);
        $response->assertJson([
            'success' => true,
            'data' => $cat_data,
            'message' => 'Category created successfully.'
        ]);

    }
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */

    public function test_update_category()
    {
        Category::unguard();
        $cat_data = [
            'id' => 1,
            'title' => 'technology'
        ];

        $user = User::factory()->create();
        $this->actingAs($user);

        $mock = \Mockery::mock('overload:Blog\Repository\CategoryRepository');
        $mock->shouldReceive(['update' => true, 'show' => new Category($cat_data)])->once();


        $response = $this->patch('/api/v1/categories/1', [
            'title' => 'technology'
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => $cat_data,
            "message" => "Category updated successfully."
        ]);

    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */

    public function test_show_category()
    {
        Category::unguard();
        $cat_data = [
            'id' => 1,
            'title' => 'technology'
        ];

        $user = User::factory()->create();
        $this->actingAs($user);

        $mock = \Mockery::mock('overload:Blog\Repository\CategoryRepository');
        $mock->shouldReceive('show')->once()
            ->andReturn(new Category($cat_data));

        $response = $this->get('api/v1/categories/1');
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => $cat_data,
            'message' => 'Show category'
        ]);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */

    public function test_delete_category()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $mock = \Mockery::mock('overload:Blog\Repository\CategoryRepository');
        $mock->shouldReceive('delete')->once()
            ->andReturnTrue();

        $response = $this->delete('api/v1/categories/1');
        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'data' => true,
            'message' => 'Category deleted successfully.'
        ]);
    }
}
