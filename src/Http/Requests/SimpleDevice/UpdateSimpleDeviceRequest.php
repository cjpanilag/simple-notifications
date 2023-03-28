<?php

namespace Cjpanilag\SimpleNotifications\Http\Requests\SimpleDevice;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateSimpleDeviceRequest
 *
 * @author Carl Jeffrie Panilag <carljeffrie.panilag>
 */
class UpdateSimpleDeviceRequest extends FormRequest
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
