<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SchoolYearRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'school_year_name' => [
            //     'required',
            //     Rule::unique('school_years')->where(fn ($query) => $query->where('school_year_start', request()->school_year_start)->where('school_year_end',request()->school_year_end))->ignore(request()->id)
            // ],
            'school_year_start' => [
                'required',
                'integer',
                'min:'.date('Y'),
                'digits:4',
                Rule::unique('school_years')->ignore(request()->id)
            ],
            'school_year_end' => [
                'required',
                'integer',
                'after:school_year_start',
                'digits:4',
                Rule::unique('school_years')->ignore(request()->id)
            ],
            'date_of_fine' => 'required|integer|max:31|min:1',
            'fine_amount' => 'integer|min:0',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            // 'school_year_start.min' => 'school year minimal '.date('Y')
        ];
    }
}
