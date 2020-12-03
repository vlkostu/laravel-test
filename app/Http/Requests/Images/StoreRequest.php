<?php

namespace App\Http\Requests\Images;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreRequest extends FormRequest
{

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'widths' => Str::of($this->widths)->explode(',')->toArray()
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'image' => 'required|mimes:jpeg,png|dimensions:min_width=20,min_height=20',
            'ratio' => 'required|between:1.0,10',
            'widths' => 'required|array|max:20',
            'watermark_url' => 'nullable|url',
            'tags' => 'nullable|string|min:1',
            'delete_at' => 'nullable|numeric'
        ];
    }

}
