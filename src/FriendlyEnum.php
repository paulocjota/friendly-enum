<?php

namespace Paulocjota;

trait FriendlyEnum
{
    /**
     * Get an array with key value
     *
     * @param  string $enum
     * @param  bool $capitalize
     * @return array
     */
    public static function getEnum(string $enum, bool $capitalize = false): array
    {
        $curEnum = self::getEnumConstants()['ENUM_' . mb_strtoupper($enum)];

        $return = [];

        if ($capitalize) {
            foreach ($curEnum as $key => $value) {
                $return[$key] = mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
            }

            return $return;
        }

        return $curEnum;
    }

    /**
     * Get an array with only keys
     *
     * @param  string $enum
     * @return array
     */
    public static function getEnumKeys(string $enum): array
    {
        return array_keys(self::getEnumConstants()['ENUM_' . mb_strtoupper($enum)]);
    }

    /**
     * Get a string with all keys, each one separated by a comma
     *
     * @param  string $enum
     * @return string
     */
    public static function getEnumKeysAsString(string $enum): string
    {
        return implode(',', array_flip(self::getEnumConstants()['ENUM_' . mb_strtoupper($enum)]));
    }

    /**
     * Get key as a string passing the value
     *
     * @param  string $enum
     * @param  string $value
     * @return string
     */
    public static function getEnumKey(string $enum, string $value): string
    {
        $curEnum = self::getEnumConstants()['ENUM_' . mb_strtoupper($enum)];
        return array_flip($curEnum)[mb_strtolower($value)] ?? '';
    }

    /**
     * Get value as a string passing the key
     *
     * @param  string $enum
     * @param  string $key
     * @param  bool $capitalize
     * @return string
     */
    public static function getEnumValue(string $enum, string $key, bool $capitalize = false): string
    {
        $curEnum = self::getEnumConstants()['ENUM_' . mb_strtoupper($enum)];

        $str = $curEnum[mb_strtolower($key)] ?? '';
        return $capitalize ? mb_convert_case($str, MB_CASE_TITLE, 'UTF-8') : $str;
    }


    // Internal use only

    /**
     * Get an array with class constants prefixed with "ENUM_"
     *
     * @return array
     */
    private static function getEnumConstants(): array
    {
        return array_filter(self::getClassConstants(), function ($key) {
            return self::startsWithEnum($key);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Return true when the passed string has the "ENUM_" prefix, otherwise
     * returns false
     *
     * @param  mixed $string
     * @return bool
     */
    private static function startsWithEnum($string): bool
    {
        if (mb_substr($string, 0, 5) === 'ENUM_') {
            return true;
        }

        return false;
    }

    /**
     * Get an array with all class constants
     *
     * @return array
     */
    private static function getClassConstants(): array
    {
        return (new \ReflectionClass(self::class))->getConstants();
    }
}
