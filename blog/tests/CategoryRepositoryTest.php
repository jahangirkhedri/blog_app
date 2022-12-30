<?php

namespace Blog\tests;

use App\Models\User;
use Blog\Models\Category;
use Blog\Repository\CategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */

    use RefreshDatabase;
    public function test_create_category()
    {
        $data = [
            'title' => 'IT'
        ];
        $category = new CategoryRepository(new Category());
        $category->create($data);

        $this->assertDatabaseHas('categories', $data);

    }

    public function test_show_category()
    {
        $data = Category::create([
            'title' => 'IT'
        ])->toArray();
        $category = new CategoryRepository(new Category());
        $response = $category->show($data['id']);
        $this->assertEquals($data, $response->toArray());
    }

    public function test_update_category()
    {
        $data = Category::create([
            'title' => 'IT'
        ])->toArray();
        $category = new CategoryRepository(new Category());
        $category->update(['title' => 'Information Technology'], $data['id']);
        $response = $category->show($data['id']);
        $this->assertEquals($response->title, 'Information Technology');

    }

    public function test_delete_category()
    {
        $data = Category::create([
            'title' => 'IT'
        ])->toArray();
        $category = new CategoryRepository(new Category());
        $response = $category->delete($data['id']);
        $this->assertEquals(1, $response);
        $this->assertDatabaseMissing('categories', $data);
    }
}
