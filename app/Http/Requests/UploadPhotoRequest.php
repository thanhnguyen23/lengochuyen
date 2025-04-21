<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadPhotoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'photo' => 'required|image|mimes:jpg,png,jpeg,max:2048|dimensions:min_width=600,min_height=600',
        ];
    }

    public function messages(): array
    {
        return [
            'photo.required' => 'Vui lòng chọn ảnh.',
            'photo.image' => 'Tệp tải lên phải là ảnh.',
            'photo.mimes' => 'Chỉ chấp nhận các định dạng: JPG, PNG, JPEG',
            'photo.max' => 'Ảnh không được lớn hơn 2MB.',
            'photo.dimensions' => 'Kích thước ảnh phải 600x600px.',
        ];
    }
}
