<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class UserService
 * @package App\Services
 */
class PostRepository extends BaseRepository
{
    protected $model;

    public function __construct(
        Post $model
    ){
        $this->model = $model;
        parent::__construct($model);
    }

    

    public function getPostById(int $id = 0, $language_id = 0){
        $publishColumn = Schema::hasColumn('posts', 'publish') ? 'posts.publish' : 'posts.pubish';
        $canonicalSelect = Schema::hasColumn('post_language', 'canonical') ? 'tb2.canonical' : DB::raw("'' as canonical");

        return $this->model->select([
                'posts.id',
                'posts.post_catalogue_id',
                'posts.image',
                'posts.icon',
                'posts.album',
                DB::raw($publishColumn.' as publish'),
                'posts.video',
                'posts.template',
                'posts.created_at',
                'posts.viewed',
                'posts.status_menu',
                'posts.short_name',
                'posts.logo',
                'posts.extra',
                'posts.comments',
                'posts.rate',
                'posts.post_type',
                'posts.recommend',
                'tb2.name',
                'tb2.description',
                'tb2.content',
                'tb2.meta_title',
                'tb2.meta_keyword',
                'tb2.meta_description',
                $canonicalSelect,
            ]
        )
        ->join('post_language as tb2', 'tb2.post_id', '=','posts.id')
        ->with('post_catalogues')
        ->where('tb2.language_id', '=', $language_id)
        ->find($id);
    }

}
