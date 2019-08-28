<?php

namespace App\Http\Requests;

use App\Genre;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

class UpdateGenreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update', Genre::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nameFr' => [
                'required',
                'string',
                Rule::unique('genres', 'name_fr')->ignore(Route::input('genre'))],
            'nameEn' => [
                'required',
                'string',
                Rule::unique('genres', 'name_en')->ignore(Route::input('genre'))],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return Lang::get('validation/updateGenre');
    }
}
