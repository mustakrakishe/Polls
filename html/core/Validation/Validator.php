<?php

namespace Core\Validation;

use Core\ORM\Contracts\ModelInterface;
use Core\Validation\Concerns\Rules;
use Core\Validation\Contracts\ValidatorInterface;
use Exception;
use ReflectionMethod;

class Validator implements ValidatorInterface
{
    use Rules;

    protected ModelInterface $model;
    protected array $errors = [];

    public function __construct(ModelInterface $model)
    {
        $this->model = $model;
    }

    public function validate(array $input, array $rules)
    {
        array_walk($rules, [$this, 'validateField'], $input);

        if ($this->errors()) {
            $_SESSION['errors'] = $this->errors();
            $_SESSION['old']    = $input;

            throw new Exception(json_encode('Validation failed'), 422);
        }
    }

    protected function validateField(array $fieldRules, string $fieldName, array $input)
    {
        $value = $input[$fieldName] ?? null;

        array_walk($fieldRules, [$this, 'applyRule'], compact('value', 'fieldName'));
    }

    protected function applyRule($rule, $ruleIndex, $args)
    {
        extract($args);
        extract($this->parseRule($rule));

        if (!empty($value) || $rule === 'required') {
            $isPassed = call_user_func([$this, $method], $value, ...$parameterValues);

            if (!$isPassed) {
                $this->errors[$fieldName][] = $this->message($method, $fieldName, $parameterKeys, $parameterValues);
            }
        }
    }

    protected function parseRule(string $string)
    {
        $ruleParts      = explode(':', $string);
        $method         = $ruleParts[0];

        $hasArguments   = count($ruleParts) > 1;

        return [
            'method'            => $method,
            'parameterValues'   => $hasArguments ? explode(',', $ruleParts[1]) : [],
            'parameterKeys'     => $hasArguments ? $this->getRuleArgumentKeys($this, $method) : [],
        ];
    }

    protected function getRuleArgumentKeys(object $object, string $method)
    {
        $reflectionMethod       = new ReflectionMethod($object, $method);
        $reflectionParameters   = $reflectionMethod->getParameters();

        $withoutColumnName      = array_slice($reflectionParameters, 1);

        return array_map(function ($reflectionParameter) {
            return $reflectionParameter->getName();
        }, $withoutColumnName);
    }

    protected function message(string $rule, string $field, array $parameterKeys, array $parameterValues)
    {
        $parameterKeyTemplates = array_map(fn ($key) => ":$key", $parameterKeys);

        $search = [
            ':attribute',
            ...$parameterKeyTemplates,
        ];

        $replace = [
            $field,
            ...$parameterValues,
        ];

        $subject = $this->messages()[$rule];

        return str_replace($search, $replace, $subject);
    }

    protected function messages()
    {
        return [
            'required'  => 'The :attribute field is required.',
            'email'     => 'The :attribute must be a valid email adress.',
            'min'       => 'The :attribute must be at least :limit characters.',
            'unique'    => 'The :attribute must be unique.',
        ];
    }

    public function errors() : array
    {
        return $this->errors;
    }
}