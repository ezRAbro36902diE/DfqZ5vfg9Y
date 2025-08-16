<?php
// 代码生成时间: 2025-08-16 13:59:51
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Mvc\Model\MessageInterface;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Regex;
use Phalcon\Validation\Validator\Confirmation;

class Users extends \u007BPhalcon\Mvc\Model\u007D
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $created_at;

    // Use Phalcon built-in ORM methods to prevent SQL injection
    // Phalcon ORM uses prepared statements internally
    public function findUsersByCriteria($criteria = "")
    {
        $criteria = new Criteria();
        $criteria->setModelName('Users');
        $criteria->appendWhere('id > ' . $criteria->createBound('A0'), 0); // Bound parameters to prevent SQL injection
        $criteria->appendWhere('name = ' . $criteria->createBound('A1'), $this->name); // Bound parameters to prevent SQL injection
        $criteria->appendWhere('email = ' . $criteria->createBound('A2'), $this->email); // Bound parameters to prevent SQL injection

        // Execute the query and return the result set
        $resultset = $criteria->execute();

        return $resultset;
    }

    // Function to validate user input to prevent SQL injection
    public function validateUserInput($input)
    {
        $validation = new Validation();

        $validation->add('name', new PresenceOf(array(
            'message' => 'Name is required'
        )));

        $validation->add('email', new PresenceOf(array(
            'message' => 'Email is required'
        )));
        $validation->add('email', new Email(array(
            'message' => 'Email is not valid'
        )));

        $validation->add('password', new PresenceOf(array(
            'message' => 'Password is required'
        )));
        $validation->add('password', new StringLength(array(
            'min' => 8,
            'messageMinimum' => 'Password is too short. Minimum 8 characters'
        )));

        $validation->add('confirm_password', new PresenceOf(array(
            'message' => 'Password confirmation is required'
        )));

        $validation->add('confirm_password', new Confirmation(array(
            'message' => 'Password does not match',
            'with' => 'password'
        )));

        // Validate the input
        $messages = $validation->validate($input);

        if (count($messages)) {
            foreach ($messages as $message) {
                // Handle the error messages
                echo $message->getMessage(), "\
";
            }
            return false;
        } else {
            return true;
        }
    }

    // Function to create a new user, ensuring SQL injection prevention
    public function createUser($input)
    {
        if (!$this->validateUserInput($input)) {
            return false;
        }

        // Use ORM to create a new record, which prevents SQL injection
        $user = new Users();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = password_hash($input['password'], PASSWORD_DEFAULT); // Hash the password
        $user->created_at = date("Y-m-d H:i:s");

        if (!$user->save()) {
            // Handle the error messages
            foreach ($user->getMessages() as $message) {
                echo $message->getMessage(), "\
";
            }
            return false;
        }

        return $user;
    }
}
