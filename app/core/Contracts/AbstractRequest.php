<?php

namespace Core\Contracts;

use Core\Validation\Contracts\ValidatorInterface;

abstract class AbstractRequest
{
    protected array $input;

    public function __construct(array $input, ValidatorInterface $validator)
    {
        $validator->validate($input, $this->rules());

        $this->input = $input;
    }

    abstract protected function rules() : array;

    public function input(string $key = null)
    {
        return is_null($key)
            ? $this->input
            : $this->input[$key];
    }
}