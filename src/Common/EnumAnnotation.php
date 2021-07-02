<?php


namespace Zbanx\Kit\Common;

use ReflectionClass;
use ReflectionClassConstant;

/**
 * Trait EnumAnnotation 枚举类型的注解支持
 * @package Zbanx\Kit\Traits
 */
trait EnumAnnotation
{
    /**
     * 获取常量值对应的 Message
     * @param string $name 常量名称
     * @param int|string $value 常量值
     * @param mixed|null $default 默认返回值
     * @return mixed|null
     */
    public static function getEnumMessage(string $name, $value, $default = null)
    {
        $ref = new ReflectionClass(static::class);
        $classConstants = $ref->getReflectionConstants();
        $arr = static::getAnnotationsByName($name, $classConstants);
        return key_exists($value, $arr) ? $arr[$value] : $default;
    }

    public static function getEnums(string $name): array
    {
        $ref = new ReflectionClass(static::class);
        $classConstants = $ref->getReflectionConstants();
        return static::getAnnotationsByName($name, $classConstants);
    }

    public static function getValues(string $name): array
    {
        return array_keys(static::getEnums($name));
    }

    protected static function getAnnotationsByName($name, $classConstants): array
    {
        $result = [];
        /** @var ReflectionClassConstant $classConstant */
        foreach ($classConstants as $classConstant) {
            $code = $classConstant->getValue();
            $docComment = $classConstant->getDocComment();
            $message = static::getCommentByName($docComment, $name);
            if ($message) {
                $result[$code] = $message;
            }
        }
        return $result;
    }

    protected static function getCommentByName($doc, $name)
    {
        $pattern = "/\@Message\([\'|\\\"]{$name}[\'|\\\"],[\'|\\\"](.*)[\'|\\\"]\)/U";
        preg_match($pattern, $doc, $result);
        return $result[1] ?? null;
    }
}
