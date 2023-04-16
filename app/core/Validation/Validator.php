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
                [$rule, $limit] = explode(':', $rule);

                if (isset($input[$field]) || $rule !== 'required') {
                    $isPassed = call_user_func([$this, $rule], $input[$field] ?? null, $limit);
    
                    if (!$isPassed) {
                        $this->errors[$field][] = $this->message($rule, $field, $limit);
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

    protected function message(string $rule, string $field, int $limit = null)
    {
        $search = [
            ':attribute',
            ':limit',
        ];

        $replace = [
            $field,
            $limit,
        ];

        $subject = $this->messages()[$rule];

        return str_replace($search, $replace, $subject);
    }

    protected function messages()
    {
        return [
            'required'  => 'The :attribute field is required.',
            'email'     => 'The :attribute must be a valid email adress.',
            'min'       => 'The :attribute must be at least :limit characters'
        ];
    }

    public function errors() : array
    {
        return $this->errors;
    }
}