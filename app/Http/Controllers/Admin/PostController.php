<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PostCurrencySalaryEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\Post\StoreRequest;
use App\Imports\PostImport;
use App\Models\Company;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class PostController extends Controller
{
    use ResponseTrait;

    private string $table;
    private object $model;

    public function __construct()
    {
        $this->model = Post::query();
        $this->table = (new Post())->getTable();

        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }

    public function index()
    {
        $data = $this->model->get();
        return view('admin.posts.index', [
            'data' => $data,
        ]);
    }

    public function create()
    {
        $currencies = PostCurrencySalaryEnum::asArray();
        return \view('admin.posts.create', [
            'currencies' => $currencies,
        ]);
    }

    public function store(StoreRequest $request)
    {
        dd($request->all());
    }

    public function importCsv(Request $request): JsonResponse
    {
        try {
            Excel::import(new PostImport, $request->file('file'));
            return $this->successResponse();
        } catch (\Throwable $e) {
            return $this->errorResponse();
        }

    }
}
