<?php

namespace Core\Validation;

use Core\Validation\Concerns\Rules;
use Core\Validation\Contracts\ValidatorInterface;
use Exception;

class Validator implements ValidatorInterface
{
    use Rules;

    protected array $errors = [];

    public function validate(array $input, array $rules)
    {
        foreach ($rules as $field => $fieldRules) {
            foreach ($fieldRules as $rule) {
                $ruleParts  = explode(':', $rule);

                $method     = $ruleParts[0];
                
                if (isset($ruleParts[1])) {
                    $arguments = explode(',', $ruleParts[1]);
                } else {
                    $arguments = [];
                }

                if (isset($input[$field]) || $rule !== 'required') {
                    $isPassed = call_user_func([$this, $method], $input[$field] ?? null, ...$arguments);
    
                    if (!$isPassed) {
                        $this->errors[$field][] = $this->message($method, $field, ...$arguments);
                    }
                }
            }
        }

        if ($this->errors()) {
            $_SESSION['errors'] = $this->errors();
            $_SESSION['old']    = $input;

            throw new Exception(json_encode('Validation failed'), 422);
        }
    }

    protected function message(string $rule, string $field, ...$arguments)
    {
        $search = [
            ':attribute',
            ...array_map(fn ($argument) => ":$argument", $arguments),
        ];

        $replace = [
            $field,
            ...$arguments,
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