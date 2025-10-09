<?php
// 代码生成时间: 2025-10-10 02:57:34
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Resultset;
use Phalcon\Mvc\Model\Transaction\Manager;

/**
 * Personalized Learning Path Model
 *
 * @property int $id
 * @property string $user_id
 * @property string $course_id
 * @property string $path_status
 * @property string $created_at
 */
class PersonalizedLearningPath extends Model
{
    /**
     * @Primary
     * @Identity
     * @Column(type="integer", nullable=false)
     */
    protected $id;

    /**
     * @Column(type="string", nullable=false)
     */
    protected $user_id;

    /**
     * @Column(type="string", nullable=false)
     */
    protected $course_id;

    /**
     * @Column(type="string", nullable=false)
     */
    protected $path_status;

    /**
     * @Column(type="datetime", nullable=false)
     */
    protected $created_at;

    /**
     * Initializes the model
     */
    public function initialize()
    {
        $this->setSource("personalized_learning_paths");
    }

    /**
     * Creates a new personalized learning path
     *
     * @param string $userId
     * @param string $courseId
     * @param string $pathStatus
     * @return bool
     */
    public function createPath($userId, $courseId, $pathStatus)
    {
        try {
            $this->user_id = $userId;
            $this->course_id = $courseId;
            $this->path_status = $pathStatus;
            $this->created_at = date("Y-m-d H:i:s");

            $transactionManager = $this->getDI()->get(Manager::class);
            $transaction = $transactionManager->get();

            if ($this->save() === false) {
                $transaction->rollback("Failed to save personalized learning path.");
                foreach ($this->getMessages() as $message) {
                    throw new \Exception($message->getMessage());
                }
            } else {
                $transaction->commit();
            }

            return true;
        } catch (\Exception $e) {
            // Handle error
            return false;
        }
    }

    /**
     * Updates an existing personalized learning path
     *
     * @param int $id
     * @param string $userId
     * @param string $courseId
     * @param string $pathStatus
     * @return bool
     */
    public function updatePath($id, $userId, $courseId, $pathStatus)
    {
        try {
            $this->id = $id;
            $this->user_id = $userId;
            $this->course_id = $courseId;
            $this->path_status = $pathStatus;
            $this->created_at = date("Y-m-d H:i:s");

            if ($this->update() === false) {
                foreach ($this->getMessages() as $message) {
                    throw new \Exception($message->getMessage());
                }
            }

            return true;
        } catch (\Exception $e) {
            // Handle error
            return false;
        }
    }

    /**
     * Deletes a personalized learning path
     *
     * @param int $id
     * @return bool
     */
    public function deletePath($id)
    {
        try {
            $this->id = $id;

            if ($this->delete() === false) {
                foreach ($this->getMessages() as $message) {
                    throw new \Exception($message->getMessage());
                }
            }

            return true;
        } catch (\Exception $e) {
            // Handle error
            return false;
        }
    }

    /**
     * Retrieves a personalized learning path by ID
     *
     * @param int $id
     * @return PersonalizedLearningPath|null
     */
    public static function findPathById($id)
    {
        return self::findFirst(["id = :id:"], ["id" => $id]);
    }
}
