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
            'email' => 'required|email|unique:users,email,' . $this->user,
            'password' => 'required|string|min:6|confirmed',
            'country_id'=> 'required',
        ];
    }

    /**
     * پیام‌های خطای سفارشی برای اعتبارسنجی
     */
    public function messages(): array
    {
        return [
            'name.required' => 'لطفاً نام خود را وارد کنید.',
            'name.string' => 'نام باید یک رشته متنی باشد.',
            'name.max' => 'نام نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
            'email.required' => 'وارد کردن ایمیل ضروری است.',
            'email.email' => 'فرمت ایمیل صحیح نیست.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',
            'password.required' => 'رمز عبور الزامی است.',
            'password.min' => 'رمز عبور باید حداقل ۶ کاراکتر باشد.',
            'password.confirmed' => 'تاییدیه رمز عبور مطابقت ندارد.',
            'country_id.required'=>'کشور مد نظر خود را انتخاب نمایید',
        ];
    }
}
