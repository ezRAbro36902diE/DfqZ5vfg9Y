<?php
// 代码生成时间: 2025-09-29 00:01:57
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\MessageInterface;
use Phalcon\Filter;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\PresenceOf as PresenceValidator;
use Phalcon\Mvc\Model\Exception;

class DigitalIdentityVerification extends Model
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * Validates the input data for digital identity verification.
     *
     * @return boolean
     */
    public function validate(): bool
    {
        $validation = new Validation();

        // Email validator
        $emailValidator = new EmailValidator(
            [
                'model' => $this,
                'attribute' => 'email'
            ]
        );
        $validation->add('email', $emailValidator);

        // Presence of email validator
        $presenceOfEmailValidator = new PresenceValidator(
            [
                'model' => $this,
                'attribute' => 'email',
                'message' => 'Email is required'
            ]
        );
        $validation->add('email', $presenceOfEmailValidator);

        // Presence of password validator
        $presenceOfPasswordValidator = new PresenceValidator(
            [
                'model' => $this,
                'attribute' => 'password',
                'message' => 'Password is required'
            ]
        );
        $validation->add('password', $presenceOfPasswordValidator);

        // Perform the validation
        $messages = $validation->validate($this);

        // Check if there are any validation messages
        if (count($messages)) {
            foreach ($messages as $message) {
                $this->appendMessage($message);
            }
            return false;
        }

        return true;
    }

    /**
     * Appends a validation message to the model.
     *
     * @param MessageInterface $message
     */
    public function appendMessage(MessageInterface $message): void
    {
        $this->messages[] = $message;
    }

    /**
     * Returns the validation messages.
     *
     * @return MessageInterface[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
