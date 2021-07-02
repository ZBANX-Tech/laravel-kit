<?php
/**
 * PhpStorm高级元数据
 * @see https://www.jetbrains.com/help/phpstorm/ide-advanced-metadata.html
 */

namespace Illuminate\Database\Eloquent {

    use Zbanx\Kit\Common\Paginate;

    /**
     * Class Builder
     * @package Illuminate\Database\Eloquent
     * @see \Illuminate\Database\Eloquent\Builder
     */
    class Builder
    {
        /**
         * 日期筛选，避免使用 mysql 中的 date 函数
         * @param string $column
         * @param string|array $date
         * @return Builder
         * @see \Zbanx\Kit\Providers\Macros\BuilderMacros::whereDateBetween();
         */
        public function whereDateBetween($column, $date): Builder
        {

        }

        /**
         * 分页处理
         * @param integer $page
         * @param integer $size
         * @param integer|null $max_length
         * @return Paginate
         * @see \Zbanx\Kit\Providers\Macros\BuilderMacros::paging();
         */
        public function paging($page, $size, $max_length = null): Paginate
        {

        }
    }
}

namespace Illuminate\Console {
    /**
     * Class Command
     * @package Illuminate\Console
     * @see \Illuminate\Console\Command
     */
    class Command
    {
        /**
         * 输出带时间的内容
         * @param $string
         * @param $style
         * @see \Zbanx\Kit\Providers\Macros\CommandMacros::print();
         */
        public function print($string, $style = "info")
        {

        }
    }
}

namespace Illuminate\Database\Eloquent {

    class Collection
    {
        /**
         * 合并集合当当前集合的某个字段
         * @param Collection $collection
         * @param string $name
         * @param string $fk
         * @param string $pk
         * @see \Zbanx\Kit\Providers\Macros\CollectionMacros::mergeWithColumn();
         */
        public function mergeWithColumn(Collection $collection, string $name, string $fk, string $pk = 'id'): Collection
        {

        }

        /**
         * 附加 json 列的关联数据到当前集合
         * @param string $column
         * @param Builder $query
         * @param string $key
         * @see \Zbanx\Kit\Providers\Macros\CollectionMacros::withJsonColumnRelation();
         */
        public function withJsonColumnRelation(string $column, Builder $query, $key = "id"): Collection
        {

        }

        /**
         * 附加 addSelect 查询出的关联数据
         * @param string $column
         * @param Builder $query
         * @param string $key
         * @see \Zbanx\Kit\Providers\Macros\CollectionMacros::withAddSelectRelation();
         */
        public function withAddSelectRelation(string $column, Builder $query, $key = "id"): Collection
        {

        }

    }
}
