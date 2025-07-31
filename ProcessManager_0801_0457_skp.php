<?php
// 代码生成时间: 2025-08-01 04:57:32
use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\PresenceOf as PresenceOfValidator;

class ProcessManager extends Model
{
    // Define the properties of the process
    protected $id;
    protected $name;
    protected $status;
    protected $created_at;
    protected $updated_at;

    // Initialize the process manager
    public function initialize()
    {
        $this->setSource('processes');
    }

    // Validate the process data
    public function validation()
    {
        $validation = new Validation();

        // Validate the presence of name
        $validation->add(
            $this,
            new PresenceOfValidator(
                array(
                    'message' => 'Process name is required'
                )
            )
        );

        // Validate the process name is unique
        $validation->add(
            $this,
            new UniquenessValidator(
                array(
                    'model' => $this,
                    'message' => 'Process name must be unique'
                )
            )
        );

        // Validate the process status
        $validation->add(
            $this,
            new InclusionInValidator(
                array(
                    'domain' => array('pending', 'active', 'completed', 'failed'),
                    'message' => 'Invalid process status'
                )
            )
        );

        return $this->validate($validation);
    }

    // Create a new process
    public function createProcess($name, $status = 'pending')
    {
        $this->name = $name;
        $this->status = $status;
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');

        if ($this->validation() && $this->save()) {
            return array(
                'success' => true,
                'message' => 'Process created successfully'
            );
        } else {
            return array(
                'success' => false,
                'message' => $this->getMessages()
            );
        }
    }

    // Update an existing process
    public function updateProcess($id, $name = null, $status = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->updated_at = date('Y-m-d H:i:s');

        if ($this->validation() && $this->update()) {
            return array(
                'success' => true,
                'message' => 'Process updated successfully'
            );
        } else {
            return array(
                'success' => false,
                'message' => $this->getMessages()
            );
        }
    }

    // Delete a process
    public function deleteProcess($id)
    {
        $this->id = $id;

        if ($this->delete()) {
            return array(
                'success' => true,
                'message' => 'Process deleted successfully'
            );
        } else {
            return array(
                'success' => false,
                'message' => 'Error deleting process'
            );
        }
    }
}
