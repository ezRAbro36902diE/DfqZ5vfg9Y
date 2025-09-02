<?php
// 代码生成时间: 2025-09-03 03:43:26
 * This library provides a set of user interface components that can be easily
 * integrated into any Phalcon application. It follows the best practices
 * of PHP and Phalcon framework to ensure maintainability and extensibility.
 */

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\PresenceOf as PresenceOfValidator;

class UIComponentLibrary extends Model
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * Validations for the UI component
     */
    public function validation()
    {
        $validator = new Validation();

        // Name must be present
        $validator->add(
            $this,
            new PresenceOfValidator(
                array(
                    "field" => $this->name,
                    "message" => "Name is required"
                )
            )
        );

        // Description must be present
        $validator->add(
            $this,
            new PresenceOfValidator(
                array(
                    "field" => $this->description,
                    "message" => "Description is required"
                )
            )
        );

        // Name must be a string
        $validator->add(
            "name",
            new StringLength(
                array(
                    "min" => 1,
                    "messageMinimum" => "Name is too short. Minimum 1 character"
                )
            )
        );

        // Description must be a string
        $validator->add(
            "description",
            new StringLength(
                array(
                    "min" => 1,
                    "messageMinimum" => "Description is too short. Minimum 1 character"
                )
            )
        );

        return $this->validate($validator);
    }

    /**
     * Save the UI component to the database
     *
     * @return bool
     */
    public function saveComponent()
    {
        if ($this->validation()) {
            $this->save();
            return true;
        } else {
            foreach ($this->getMessages() as $message) {
                echo $message;
            }
            return false;
        }
    }
}
