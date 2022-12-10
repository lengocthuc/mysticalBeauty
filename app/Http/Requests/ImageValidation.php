<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageValidation extends FormRequest
{
    protected $stopOnFirstFailure = true;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //dd($this->validationData());
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'imgs' => 'max:51200',
            'imgs.*' => 'required|mimes:image',
        ];
    }
    public function messages()
    {
        return [
            'imgs.required' => 'không được bỏ trống',
            'imgs.mimes' => 'Không phải là ảnh',
            'imgs.max' => 'kích thước không được quá 25MB',
        ];
    }

}
