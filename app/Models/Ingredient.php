<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'stock',
        'minimum_stock',
    ];

    protected function casts(): array
    {
        return [
            'stock' => 'decimal:2',
            'minimum_stock' => 'decimal:2',
        ];
    }

    public function isLowStock(): bool
    {
        return $this->stock <= $this->minimum_stock;
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }
}
