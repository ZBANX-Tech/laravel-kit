<?php

namespace Zbanx\Kit\Common;

use Closure;
use Illuminate\Database\Eloquent\Collection;

class Paginate
{
    /** @var int */
    private $total;
    /** @var Collection */
    private $items;
    /** @var array */
    private $append = [];

    public function __construct(Collection $items, int $total)
    {
        $this->items = $items;
        $this->total = $total;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function setItems(Collection $items): Paginate
    {
        $this->items = $items;
        return $this;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function mapItems(Closure $closure): Paginate
    {
        $this->items = $this->items->map($closure);
        return $this;
    }

    public function toArray(): array
    {
        return array_merge($this->append, [
            'total' => $this->total,
            'data' => $this->items
        ]);
    }

    public function append($key, $value): Paginate
    {
        $this->append[$key] = $value;
        return $this;
    }

    public function pluck($key, $return_array = true)
    {
        $result = $this->items->pluck($key);
        return $return_array ? $result->toArray() : $result;
    }
}
