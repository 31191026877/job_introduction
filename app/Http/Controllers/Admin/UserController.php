<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UserController extends Controller
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

    public function index(Request $request)
    {
        $selectedRole = $request->get('role');
        $selectedCity = $request->get('city');
        $selectedCompany = $request->get('company');
        $query = $this->model->clone()
            ->with('company:id,name')
            ->latest();
        if (!is_null($selectedRole)) {
            $query->where('role', $selectedRole);
        }
        if (!is_null($selectedCity)) {
            $query->where('city', $selectedCity);
        }
        if (!is_null($selectedCompany)) {
            $query->whereHas('company', function ($q) use ($selectedCompany) {
                return $q->where('id', $selectedCompany);
            });
        }
        $cities = $this->model->clone()
            ->distinct()
            ->limit(10)
            ->whereNotNull('city')
            ->pluck('city');
        $data = $query->paginate();
        $roles = UserRoleEnum::asArray();
        $companies = Company::query()
            ->get([
                'id',
                'name',
            ]);
        return view("admin.$this->table.index", [
            'data' => $data,
            'roles' => $roles,
            'selectedRole' => $selectedRole,
            'selectedCity' => $selectedCity,
            'selectedCompany' => $selectedCompany,
            'companies' => $companies,
            'cities' => $cities,
        ]);
    }

    public function show($userId)
    {
        $user = User::query()->where('id', $userId)->first();
        dd($user->toArray());
    }

    public function destroy($userId): RedirectResponse
    {
        User::destroy($userId);
        return redirect()->back();
    }
}
