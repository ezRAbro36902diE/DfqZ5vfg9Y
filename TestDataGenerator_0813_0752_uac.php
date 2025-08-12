<?php
// 代码生成时间: 2025-08-13 07:52:34
use Phalcon\DI;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\ValidationFailed;
use Phalcon\Config;
use Phalcon\Loader;

class TestDataGenerator
{

    protected $di;

    public function __construct(DI $di)
    {
        $this->di = $di;
    }

    /**
     * Generate test data for a given model.
     *
     * @param string $modelName
     * @param int $quantity
     * @return bool
     * @throws Exception
     */
    public function generateData($modelName, $quantity = 10)
    {
        try {
            $class = $this->getModelClass($modelName);
            $source = $this->di->getShared('modelsMetadata')->getMetaData($class->getDI()->get('modelsManager')->is UsingAlias($modelName));
            $attributes = $source->getAttributes();

            for ($i = 0; $i < $quantity; $i++) {
                $record = $class::create(array());
                foreach ($attributes as $attribute) {
                    $record->$attribute = $this->generateRandomValue($attribute);
                }
                $record->save();
            }
            return true;
        } catch (Exception $e) {
            // Handle the exception
            return false;
        }
    }

    /**
     * Get the model class based on the model name.
     *
     * @param string $modelName
     * @return Model
     * @throws Exception
     */
    protected function getModelClass($modelName)
    {
        $loader = new Loader();
        $loader->registerNamespaces(array(
            'Models' => __DIR__ . '/models/'
        ));
        $loader->register();

        try {
            $class = new $modelName();
            if ($class instanceof Model) {
                return $class;
            } else {
                throw new Exception("Model not found or not a valid model class.");
            }
        } catch (Exception $e) {
            throw new Exception("Error loading model class: " . $e->getMessage());
        }
    }

    /**
     * Generate a random value for a given attribute.
     *
     * @param string $attribute
     * @return mixed
     */
    protected function generateRandomValue($attribute)
    {
        // Implement the logic to generate random values based on the attribute type
        // For simplicity, let's assume it's a string and return a random string
        return uniqid(mt_rand(), true);
    }

}
