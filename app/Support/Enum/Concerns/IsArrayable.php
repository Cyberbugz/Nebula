<?php

namespace App\Support\Enum\Concerns;

use App\Support\Enum\Contracts\StringableInterface;

trait IsArrayable
{
    public function toArray(): array
    {
        return [
            'text'  => $this instanceof StringableInterface ? $this->toString() : $this->name,
            'value' => $this->value,
        ];
    }
}
