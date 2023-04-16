<?php

namespace Core\Validation\Contracts;

interface ValidatorInterface
{
    public function validate(array $input, array $rules);
    public function errors() : array;
}