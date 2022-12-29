<?php

namespace Blog\Repository;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Repository\Repository;

class PostRepository extends Repository
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $post = $this->model->create($data);
            $post->categories()->attach($data['categories']);
            DB::commit();
            return $post;
        } catch (\Throwable $e) {
            return new \RuntimeException($e->getMessage());
        }


    }
    public function update(array $data,$id)
    {
        DB::beginTransaction();
        try {
            $this->model->update($data);
            $post = $this->show($id)->categories()->sync($data['categories']);
            DB::commit();
            return $post;
        } catch (\Throwable $e) {
            return new \RuntimeException($e->getMessage());
        }


    }

}
