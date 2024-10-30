<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * تعیین اینکه آیا کاربر مجاز به انجام این درخواست هست یا خیر
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * قوانین اعتبارسنجی برای درخواست
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'country_id' => 'required|exists:countries,id',
        ];
    }

    /**
     * پیام‌های خطای سفارشی برای اعتبارسنجی
     */
    public function messages(): array
    {
        return [
            'name.required' => 'وارد کردن نام ضروری است.',
            'email.required' => 'وارد کردن ایمیل ضروری است.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',
            'password.required' => 'رمز عبور الزامی است.',
            'country_id.required' => 'انتخاب کشور الزامی است.',
            'country_id.exists' => 'کشور انتخابی نامعتبر است.',
        ];
    }
}
