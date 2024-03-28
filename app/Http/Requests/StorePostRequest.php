<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kategori_kode' => 'required',
            'kategori_nama' => 'required',
        ];
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $validate = $request->validated();

        $validate = $request->safe()->only(['kategori_kode', 'kategori_nama']);
        $validate = $request->safe()->except(['kategori_kode', 'kategori_nama']);

        return redirect('/kategori');
    }
}