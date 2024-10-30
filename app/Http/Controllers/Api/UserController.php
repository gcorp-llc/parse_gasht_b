<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * لیست کاربران
     */
    public function index(Request $request)
    {
        // پارامترهای مرتب‌سازی و فیلتر را دریافت می‌کنیم
        $sortBy = $request->query('sort_by', 'id'); // مرتب‌سازی بر اساس فیلد مورد نظر (پیش‌فرض: id)
        $sortOrder = $request->query('sort_order', 'asc'); // ترتیب مرتب‌سازی (پیش‌فرض: صعودی)
        $searchName = $request->query('name'); // پارامتر جستجو بر اساس نام
        $countryName = $request->query('country_name'); // فیلتر بر اساس کد کشور

        // کش کردن اطلاعات کاربران با قابلیت مرتب‌سازی، جستجو و فیلتر
            $query = DB::table('users')
            ->join('countries', 'users.country_id', '=', 'countries.id')
            ->select('users.id', 'users.name', 'users.email', 'countries.name as country_name');

            // فیلتر کردن بر اساس نام کاربر
            if ($searchName) {
                $query->where('users.name', 'like', '%' . $searchName . '%');
            }

            // فیلتر کردن بر اساس کد کشور
            if ($countryName) {
                $query->where('countries.name', $countryName);
            }

            // مرتب‌سازی بر اساس فیلد مشخص‌شده
            if (in_array($sortBy, ['id', 'name']) && in_array($sortOrder, ['asc', 'desc'])) {
                $query->orderBy('users.' . $sortBy, $sortOrder);
            }

         $users = $query->get();



        return UserResource::collection($users);
    }

    /**
     * ایجاد کاربر جدید
     */
    public function store(Request $request)
    {
        // قوانین اعتبارسنجی
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'country_id' => 'required|exists:countries,id',
        ]);

        // چک کردن نتیجه اعتبارسنجی
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'country_id'=>$request->country_id
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
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // قوانین اعتبارسنجی
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'country_id' => 'required|exists:countries,id',
        ]);

        // چک کردن نتیجه اعتبارسنجی
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // به‌روزرسانی اطلاعات کاربر
        $user->update($request->only(['name', 'email', 'country_id']));

        return new UserResource($user);
    }

    /**
     * حذف کاربر
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json("Delete User  Success", 204);
    }
}
