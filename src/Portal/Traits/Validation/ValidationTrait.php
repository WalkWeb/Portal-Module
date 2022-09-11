<?php

declare(strict_types=1);

namespace Portal\Traits\Validation;

trait ValidationTrait
{
    /**
     * @param array $data
     * @param string $filed
     * @param string $error
     * @return int
     * @throws ValidationException
     */
    protected static function int(array $data, string $filed, string $error): int
    {
        if (!array_key_exists($filed, $data) || !is_int($data[$filed])) {
            throw new ValidationException($error);
        }

        return $data[$filed];
    }

    /**
     * @param array $data
     * @param string $filed
     * @param string $error
     * @return int|float
     * @throws ValidationException
     */
    protected static function intOrFloat(array $data, string $filed, string $error)
    {
        if (!array_key_exists($filed, $data) || (!is_float($data[$filed]) && !is_int($data[$filed]))) {
            throw new ValidationException($error);
        }

        return $data[$filed];
    }

    /**
     * @param array $data
     * @param string $filed
     * @param string $error
     * @return string
     * @throws ValidationException
     */
    protected static function string(array $data, string $filed, string $error): string
    {
        if (!array_key_exists($filed, $data) || !is_string($data[$filed])) {
            throw new ValidationException($error);
        }

        return $data[$filed];
    }

    /**
     * @param array $data
     * @param string $filed
     * @param string $error
     * @return array
     * @throws ValidationException
     */
    protected static function array(array $data, string $filed, string $error): array
    {
        if (!array_key_exists($filed, $data) || !is_array($data[$filed])) {
            throw new ValidationException($error);
        }

        return $data[$filed];
    }

    /**
     * @param array $data
     * @param string $filed
     * @param string $error
     * @return bool
     * @throws ValidationException
     */
    protected static function bool(array $data, string $filed, string $error): bool
    {
        if (!array_key_exists($filed, $data) || !is_bool($data[$filed])) {
            throw new ValidationException($error);
        }

        return $data[$filed];
    }

    /**
     * @param int $value
     * @param int $min
     * @param int $max
     * @param string $error
     * @return int
     * @throws ValidationException
     */
    protected static function intMinMaxValue(int $value, int $min, int $max, string $error): int
    {
        if ($value < $min || $value > $max) {
            throw new ValidationException($error);
        }

        return $value;
    }

    /**
     * @param string $string
     * @param int $minLength
     * @param int $maxLength
     * @param string $error
     * @return string
     * @throws ValidationException
     */
    protected static function stringMinMaxLength(string $string, int $minLength, int $maxLength, string $error): string
    {
        $length = mb_strlen($string);

        if ($length < $minLength || $length > $maxLength) {
            throw new ValidationException($error);
        }

        return $string;
    }
}
