<?php

namespace App\Domains\Vault\ManageAddresses\Services;

use App\Interfaces\ServiceInterface;
use App\Models\Address;
use App\Services\BaseService;

class DestroyAddress extends BaseService implements ServiceInterface
{
    private Address $address;

    /**
     * Get the validation rules that apply to the service.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'account_id' => 'required|integer|exists:accounts,id',
            'vault_id' => 'required|integer|exists:vaults,id',
            'author_id' => 'required|integer|exists:users,id',
            'address_id' => 'required|integer|exists:addresses,id',
        ];
    }

    /**
     * Get the permissions that apply to the user calling the service.
     *
     * @return array
     */
    public function permissions(): array
    {
        return [
            'author_must_belong_to_account',
            'vault_must_belong_to_account',
            'author_must_be_vault_editor',
        ];
    }

    /**
     * Delete an address.
     *
     * @param  array  $data
     */
    public function execute(array $data): void
    {
        $this->validateRules($data);

        $this->address = $this->vault->addresses()
            ->findOrFail($data['address_id']);

        $this->address->delete();
    }
}