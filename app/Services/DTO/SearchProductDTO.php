<?php

namespace App\Services\DTO;

use Illuminate\Http\Request;

class SearchProductDTO
{
    public function __construct(
        private string $query,
        private bool $isAjax = false,
        private bool $wantsJson = false
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('q', ''),
            $request->ajax(),
            $request->wantsJson()
        );
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function isAjax(): bool
    {
        return $this->isAjax;
    }

    public function wantsJson(): bool
    {
        return $this->wantsJson;
    }

}
