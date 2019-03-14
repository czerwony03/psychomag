<?php

namespace App\Http\Requests;

use App\Http\Controllers\PollController;
use Illuminate\Foundation\Http\FormRequest;

class PollRequest extends FormRequest
{
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
        $rules = [];
        foreach(PollController::$questions as $id => $question) {
            $rules['question_'.$id] = 'required';
        }
        return $rules;
    }
}
