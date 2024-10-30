<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * لیست کاربران
     */
    public function index()
    {
        // $users = User::all();
        $users= Cache::flexible('users', [5, 10], function () {
            return DB::table('users')
            ->join('countries', 'users.country_id', '=', 'countries.id')
            ->select('users.id', 'users.name', 'users.email', 'countries.name as country_name')
            ->get();
        });

        return UserResource::collection($users);
    }

    /**
     * ایجاد کاربر جدید
     */
    public function store(UserRequest $request)
    {
        // اعتبارسنجی داده‌ها


        // ایجاد کاربر جدید
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return new UserResource($user);
    }

    /**
     * مشاهده یک کاربر خاص
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }

    /**
     * به‌روزرسانی کاربر
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        // به‌روزرسانی اطلاعات کاربر
        $user->update($request->only(['name', 'email', 'password','country_id']));

        return new UserResource($user);
    }

    /**
     * حذف کاربر
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(null, 204);
    }
}
