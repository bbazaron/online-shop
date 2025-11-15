<?php

namespace App\Services\DTO;

use App\Http\Requests\CreateOrderRequest;

class CreateOrderDTO
{
    public function __construct(
        private string $contact_name,
        private string $contact_phone,
        private string $address,
        private string|null $comment,
    ){}

    public static function fromRequest(CreateOrderRequest $request): self
    {
        return new self(
            $request->get('contact_name'),
            $request->get('contact_phone'),
            $request->get('address'),
            $request->get('comment')
        );
    }

    /**
     * @return string
     */
    public function getContactName(): string
    {
        return $this->contact_name;
    }

    /**
     * @return string
     */
    public function getContactPhone(): string
    {
        return $this->contact_phone;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }





}
