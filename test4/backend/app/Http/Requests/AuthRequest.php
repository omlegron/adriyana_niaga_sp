<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
      $unique = ($id = request()->route('id')) ? ','.$id : '';
      return [
        'username' => 'required|string|max:255|min:5',
        'password' => 'required|string',
        'shift' => 'required|string',
        'pos' => 'required|string',
      ];
    }
  }
