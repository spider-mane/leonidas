<?php

namespace Backalley\Form\Managers;

use Backalley\Form\Contracts\FieldDataManagerInterface;

class FieldDataManagerCallback extends AbstractFieldDataManager implements FieldDataManagerInterface
{
    /**
     * @var callable
     */
    private $retrieveDataCallback;

    /**
     * @var callable
     */
    private $processDataCallback;

    /**
     *
     */
    public function __construct(callable $retrieveDataCallback, callable $processDataCallback)
    {
        $this->retrieveDataCallback = $retrieveDataCallback;
        $this->processDataCallback = $processDataCallback;
    }

    /**
     *
     */
    public function getCurrentData($request)
    {
        return ($this->retrieveDataCallback)($request);
    }

    /**
     *
     */
    public function handleSubmittedData($request, $data): bool
    {
        return ($this->processDataCallback)($request, $data);
    }
}
