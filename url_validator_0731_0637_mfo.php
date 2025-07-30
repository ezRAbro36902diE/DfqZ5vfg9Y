<?php
// 代码生成时间: 2025-07-31 06:37:28
use Phalcon\Http\Request;
use Phalcon\Filter;
use Phalcon\Mvc\Model\Validation;
use Phalcon\Mvc\Model\ValidationMessage;

class UrlValidator extends Phalcon\Mvc\Controller
{

    public function indexAction()
    {
        // Get the URL from the request
        $url = $this->request->getQuery('url', new Filter());
        $url = $url->sanitize(['trim']);

        // Validate the URL
        $messages = $this->validateUrl($url);

        // Check if there are any validation messages
        if (count($messages)) {
            foreach ($messages as $message) {
                $this->flash->error($message->getMessage());
            }
        } else {
            $this->flash->success('The URL is valid!');
        }
    }

    /**
     * Validate the URL
     *
     * @param string $url The URL to validate
     * @return Phalcon\Mvc\Model\Validation\Message[]
     */
    protected function validateUrl($url)
    {
        $validation = new Validation();

        // Define the validation rules
        $validation->add(
            'url',
            new Phalcon\Mvc\Model\Validator\PresenceOf(
                array(
                    'message' => 'The URL is required'
                )
            )
        );
        $validation->add(
            'url',
            new Phalcon\Mvc\Model\Validator\Url(
                array(
                    'message' => 'The URL is not valid'
                )
            )
        );

        // Assign the data to be validated
        $validation->validate($this, ['url' => $url]);

        // Return the validation messages
        return $validation->getMessages();
    }
}
