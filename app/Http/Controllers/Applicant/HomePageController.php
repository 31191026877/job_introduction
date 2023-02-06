<?php

namespace App\Http\Controllers\Applicant;

use App\Enums\PostRemotableEnum;
use App\Enums\PostStatusEnum;
use App\Enums\SystemCacheKeyEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Applicant\Homepage\IndexRequest;
use App\Models\Config;
use App\Models\Post;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index(IndexRequest $request)
    {
        $searchCities = $request->get('cities', []);
        $arrConfigs = Config::query()->where('is_public', 0)
            ->get();
        $configs = [];

        foreach ($arrConfigs as $each) {
            $configs[$each->key] = $each->value;
        }
        $minSalary = $request->get('min_salary', $configs['filter_min_salary']);
        $maxSalary = $request->get('max_salary', $configs['filter_max_salary']);
        $remotable = $request->get('remotable');
        $searchCanParttime = $request->get('can_parttime');

        $filters = [];
        if (!empty($searchCities)) {
            $filters['cities'] = $searchCities;
        }
        if ($request->has('min_salary')) {
            $filters['min_salary'] = $minSalary;
        }
        if ($request->has('max_salary')) {
            $filters['max_salary'] = $maxSalary;
        }
        if (!empty($remotable)) {
            $filters['remotable'] = $remotable;
        }
        if (!empty($searchCanParttime)) {
            $filters['can_parttime'] = $searchCanParttime;
        }

        $posts = Post::query()
            ->indexHomePage($filters)
            ->paginate();

        $arrCity = getAndCachePostCities();
        $filtersPostRemotable = PostRemotableEnum::getArrWithLowerKey();
        return view('applicant.index', [
            'posts' => $posts,
            'arrCity' => $arrCity,
            'searchCities' => $searchCities,
            'minSalary' => $minSalary,
            'maxSalary' => $maxSalary,
            'configs' => $configs,
            'filtersPostRemotable' => $filtersPostRemotable,
            'remotable' => $remotable,
            'searchCanParttime' => $searchCanParttime,
        ]);
    }

    public function show($postId)
    {
        $post = Post::query()
            ->with('file')
            ->approved()
            ->findOrFail($postId);
        $title = $post->job_title;
        return view('applicant.show', [
            'post' => $post,
            'title' => $title,
        ]);
    }
}
