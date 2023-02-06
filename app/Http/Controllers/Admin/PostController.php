<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ObjectLanguageTypeEnum;
use App\Enums\PostCurrencySalaryEnum;
use App\Enums\PostRemotableEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Controllers\SystemConfigController;
use App\Http\Requests\Post\StoreRequest;
use App\Imports\PostImport;
use App\Models\Company;
use App\Models\Language;
use App\Models\ObjectLanguage;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

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
        $configs = SystemConfigController::getAndCache();
        $remotables =PostRemotableEnum::getArrWithoutAll();
        return \view('admin.posts.create', [
            'currencies' => $configs['$currencies'],
            'countries' => $configs['$countries'],
            'remotables' => $remotables,
        ]);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $arr = $request->validated();

            $companyName = $request->get('company');

            if (!empty($companyName)) {
                $arr['company_id'] = Company::firstOrCreate(['name' => $companyName])->id;
            }
            if ($request->has('remotable')) {
                $arr['remotable'] = $request->get('remotable');
            }
            if ($request->has('can_parttime')) {
                $arr['can_parttime'] = 1;
            }
            $post = Post::create($arr);
            $languages = $request->get('languages');

            foreach ($languages as $language) {
                $language = Language::firstOrCreate(['name' => $language]);
                ObjectLanguage::create([
                    'language_id' => $language->id,
                    'object_id' => $post->id,
                    'object_type' => Post::class,
                ]);
            }
            DB::commit();
            return $this->successResponse();
        } catch (Throwable $e) {
            DB::rollback();
            return $this->errorResponse($e->getMessage());
        }
    }

    public function importCsv(Request $request): JsonResponse
    {
        try {
            Excel::import(new PostImport, $request->file('file'));
            return $this->successResponse();
        } catch (Throwable $e) {
            return $this->errorResponse();
        }

    }
}
