<?php

namespace WebTheory\Saveyour\Processors;

use Backalley\Form\Contracts\FormFieldControllerInterface;
use Swift_Mailer;
use Swift_Message;
use WebTheory\Saveyour\Contracts\FormDataProcessorInterface;

class FormDataSwiftMailer implements FormDataProcessorInterface
{
    /**
     * @var Swift_Mailer
     */
    protected $mailer;

    /**
     * @var Swift_Message
     */
    protected $message;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     *
     */
    public function __construct(Swift_Mailer $mailer, Swift_Message $message)
    {
        $this->mailer = $mailer;
        $this->message = $message;
    }

    /**
     * Get the value of fields
     *
     * @return mixed
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * Set the value of fields
     *
     * @param mixed $fields
     *
     * @return self
     */
    public function setFields($fields)
    {
        foreach ($fields as $field) {
            $this->addField($field);
        }

        return $this;
    }

    /**
     * @param FormFieldControllerInterface $field
     * @param string|array $groups
     */
    public function addField(FormFieldControllerInterface $field)
    {
        $name = $field->getFormFieldName();

        if (!in_array($name, $this->fields)) {
            $this->fields[$name] = $field;
        } else {
            throw new \Exception("This instance of " . __CLASS__ . " already has a field named {$name}");
        }

        return $this;
    }

    /**
     *
     */
    protected function extractValues($results)
    {
        $values = [];

        foreach ($results as $slug => $results) {
            $values[$slug] = $results['value'];
        }

        return $values;
    }

    /**
     *
     */
    public function run($request, $results)
    {
        $values = $this->extractValues($results);
        $message = '';

        foreach ($values as $key => $value) {
            $message .= "{$key}: {$value}\n";
        }

        $this->mailer->send($this->message->setBody($message));
    }
}
