<?php

namespace App\Enums;

enum OrderStatus: string
{
    case NEW            = 'new';
    case PROCESSING     = 'processing';
    case SHIPPED        = 'converted';
    case DELIVERED      = 'delivered';
    case CANCELLED      = 'canceled';

    public function label(): string
    {
        return match ($this) {
            self::NEW           => 'New',
            self::PROCESSING    => 'Processing',
            self::SHIPPED       => 'Converted',
            self::DELIVERED     => 'Delivered',
            self::CANCELLED     => 'Canceled',
        };
    }
    public function color(): string
    {
        return match ($this) {
            self::NEW           => 'gray',
            self::PROCESSING    => 'primary',
            self::SHIPPED       => 'purple',
            self::DELIVERED     => 'success',
            self::CANCELLED     => 'error',
        };
    }

    public static function options(): array
    {
        return array_map(fn($type) => ['value' => $type->value, 'label' => $type->label()], self::cases());
    }
}
