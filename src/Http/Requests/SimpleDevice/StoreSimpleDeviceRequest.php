<?php

namespace Cjpanilag\SimpleNotifications\Http\Requests\SimpleDevice;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreSimpleDeviceRequest
 *
 * @author Carl Jeffrie Panilag <cjpanilag@gmail.com>
 */
class StoreSimpleDeviceRequest extends FormRequest
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
            'user_id' => 'nullable',
            'device_id' => 'nullable',
            'unique_id' => 'nullable',
            'brand' => 'nullable',
            'type' => 'nullable',
            'name' => 'nullable',
            'manufacturer' => 'nullable',
            'model' => 'nullable',
            'system_name' => 'nullable',
            'system_version' => 'nullable',
            'version' => 'nullable',
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
