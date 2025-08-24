<?php
// 代码生成时间: 2025-08-24 09:21:57
 * It includes error handling and follows PHP best practices for maintainability and scalability.
 */

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\PresenceOf as PresenceOfValidator;
use Phalcon\Validation\Validator\StringLength as StringLengthValidator;

class FormValidator extends Validation
{

    /**
     * Initializes the validator rules.
     *
     * @return void
     */
    public function initialize()
    {
        // PresenceOf Validator
        $this->add(
            ['name'],
            new PresenceOfValidator([
                'message' => 'The name is required'
            ])
        );

        // StringLength Validator
        $this->add(
            ['name'],
            new StringLengthValidator([
                'min' => 5,
                'max' => 30,
                'messageMinimum' => 'The name is too short',
                'messageMaximum' => 'The name is too long'
            ])
        );

        // Email Validator
        $this->add(
            ['email'],
            new EmailValidator([
                'message' => 'The email is not valid'
            ])
        );
    }

    /**
     * Validates the form data.
     *
     * @param array $data Form data to validate.
     * @return bool
     */
    public function validate(array $data): bool
    {
        return $this->validate($data) ? true : false;
    }
}
