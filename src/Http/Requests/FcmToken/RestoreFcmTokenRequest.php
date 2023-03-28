<?php

namespace Cjpanilag\SimpleNotifications\Http\Requests\FcmToken;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RestoreFcmTokenRequest
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class RestoreFcmTokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            //
        ]);
    }
}
