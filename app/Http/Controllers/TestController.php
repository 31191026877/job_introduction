<?php

namespace App\Http\Controllers;

use App\Enums\PostRemotableEnum;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class TestController extends Controller
{
    private string $table;
    private object $model;

    public function __construct()
    {
        $this->model = User::query();
        $this->table = (new User())->getTable();

        View::share('title', ucwords($this->table));
        View::share('table', $this->table);
    }
    public function test()
    {
       $data = Post::query()->latest()->limit(3)->get();
       return $data;
    }
}
