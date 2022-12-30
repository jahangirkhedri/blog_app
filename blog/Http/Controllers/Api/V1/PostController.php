<?php

namespace Blog\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\BaseController;
use App\Http\Controllers\Controller;
use Blog\Http\Request\PostRequest;
use Blog\Http\Resources\V1\PostResource;
use Blog\Models\Post;
use Blog\Repository\PostRepository;


class PostController extends BaseController
{
    private $post;

    public function __construct(Post $post)
    {
        $this->post = new PostRepository($post);
    }

    public function index()
    {
        try {
            $data = $this->post->all();
            return $this->sendResponse($data, 'all posts');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 'An error has occurred.', 502);
        }
    }


    public function store(PostRequest $request)
    {
        try {
            $data = $request->all();
            $user=auth('sanctum')->user();
            $data['user_id'] = $user->id;
            $response = $this->post->create($data);
            return $this->sendResponse(new PostResource($response), 'Post created successfully.');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 'An error has occurred.', 502);
        }
    }


    public function show($id)
    {
        try {
            $response = $this->post->show($id);
            return $this->sendResponse(new PostResource($response), 'Show post');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 'An error has occurred.', 502);
        }
    }


    public function update(PostRequest $request, $id)
    {
        try {
            $data = $request->all();
             $this->post->update($data, $id);
             $response = $this->post->show($id);
            return $this->sendResponse(new PostResource($response), 'Post updated successfully.');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 'An error has occurred.', 502);
        }
    }


    public function destroy($id)
    {
        try {
            $response = $this->post->delete($id);
            return $this->sendResponse($response, 'Post deleted successfully.');
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage(), 'An error has occurred.', 502);
        }
    }
}
