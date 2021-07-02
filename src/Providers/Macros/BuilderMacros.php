<?php

namespace Zbanx\Kit\Providers\Macros;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Zbanx\Kit\Common\Paginate;

class BuilderMacros
{
    public function __invoke()
    {
        $this->paging();
        $this->whereDateBetween();
    }

    public function paging()
    {
        Builder::macro('paging', function ($page, $size, $max_length = null) {
            /** @var Builder $builder */
            $builder = $this;
            $take = $size;
            if ($max_length != null) {
                $size = $size > $max_length ? $max_length : $size;
                if ($page * $take > $max_length) {
                    $page = ceil($max_length / $size);
                    $take = $max_length - ($page - 1) * $size;
                }
            }
            $count = $builder->count();
            $items = $builder->skip(($page - 1) * $size)->take($take)->get();
            return new Paginate($items, $count);
        });
    }

    public function whereDateBetween()
    {
        Builder::macro('whereDateBetween', function ($column, $date) {
            /** @var Builder $builder */
            $builder = $this;
            $date = Arr::wrap($date);
            $start = Arr::first($date) . " 00:00:00";
            $end = Arr::last($date) . " 23:59:59";
            return $builder->whereBetween($column, [$start, $end]);
        });
    }
}
