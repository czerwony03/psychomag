<?php

namespace App\Http\Requests;

use App\Http\Controllers\PollPumController;
use Illuminate\Foundation\Http\FormRequest;

class PollPumRequest extends FormRequest
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
        foreach (PollPumController::$questions as $id => $question) {
            $rules['question_'.$id] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        $messages = [];
        foreach (PollPumController::$questions as $id => $question) {
            $messages['question_'.$id.'.required'] = 'Musisz odpowiedzieć na pytanie nr. '.($id+1).'!';
        }
        return $messages;
    }
}
