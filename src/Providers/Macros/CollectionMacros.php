<?php

namespace Zbanx\Kit\Providers\Macros;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class CollectionMacros
{
    public function __invoke()
    {
        $this->mergeWithColumn();
        $this->withJsonColumnRelation();
        $this->withAddSelectRelation();
    }

    // 合并集合到某一列
    public function mergeWithColumn()
    {
        Collection::macro('mergeWithColumn', function (Collection $collect, string $name, string $fk, string $pk = 'id') {
            /** @var Collection $collection */
            $collection = $this;
            return $collection->map(function ($item) use ($collect, $name, $fk, $pk) {
                $item->$name = $collect->where($fk, $item->$pk)->first();
                return $item;
            });
        });
    }


    /**
     * 为集合附加 json 列关联的数据
     */
    public function withJsonColumnRelation()
    {
        Collection::macro('withJsonColumnRelation', function (string $column, Builder $query, $key = "id") {
            /** @var Collection $collection */
            $collection = $this;
            $arr = $collection->pluck($column);
            $ids = array_unique(Arr::collapse($arr));
            $relations = $query->whereIn($key, $ids)->get();

            $columns = explode('.', $column);
            return $collection->map(function ($item) use ($columns, $relations, $key) {
                return CollectionMacros::setColumn($columns, $item, $relations, $key, true);
            });
        });
    }

    /**
     * 查询集合中附加列的关联数据
     */
    public function withAddSelectRelation()
    {
        Collection::macro('withAddSelectRelation', function (string $column, Builder $query, $key = "id") {
            /** @var Collection $collection */
            $collection = $this;
            $ids = $collection->pluck($column)->whereNotNull()->unique()->toArray();
            $relations = $query->whereIn($key, $ids)->get();
            $columns = explode('.', $column);
            return $collection->map(function ($item) use ($columns, $relations, $key) {
                return CollectionMacros::setColumn($columns, $item, $relations, $key);
            });
        });
    }


    /**
     * 根据列名路径递归附加关联信息
     *
     * @param array $columns
     * @param mixed $item
     * @param Collection $relations
     * @param string $key
     * @param boolean $is_multiple
     * @return mixed
     */
    public static function setColumn(array $columns, $item, Collection $relations, string $key = 'id', bool $is_multiple = false)
    {
        $column = array_shift($columns);
        if (empty($columns)) {
            if ($is_multiple) {
                $item->$column = $relations->whereIn($key, $item[$column])->all();
            } else {
                $item->$column = $relations->where($key, $item[$column])->first();
            }
        } else {
            $item->$column = self::setColumn($columns, $item->$column, $relations, $key, $is_multiple);
        }
        return $item;
    }
}
