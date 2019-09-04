<?php

namespace Backalley\Wordpress\Fields\Managers;

use Backalley\Form\Contracts\FieldDataManagerInterface;
use Backalley\Form\Managers\AbstractFieldDataManager;

abstract class AbstractWPEntityMetaFieldDataManager extends AbstractFieldDataManager implements FieldDataManagerInterface
{
    /**
     * @var string
     */
    protected $metaKey;

    /**
     * @var bool
     */
    protected $isUniqueValue = true;

    protected const MODEL = null;
    protected const ID_KEY = null;
    protected const NAME_KEY = null;

    /**
     *
     */
    public function __construct(string $metaKey)
    {
        $this->metaKey = $metaKey;
    }

    /**
     *
     */
    public function getCurrentData($entity)
    {
        return get_metadata(
            static::MODEL,
            $entity->{static::ID_KEY} ?? null,
            $this->metaKey,
            $this->isUniqueValue
        );
    }

    /**
     *
     */
    public function handleSubmittedData($entity, $data): bool
    {
        $response = (bool) update_metadata(
            static::MODEL,
            $entity->{static::ID_KEY},
            $this->metaKey,
            $data,
            $this->getCurrentData($entity)
        );

        return $response;
    }

    /**
     *
     */
    public function createData($entity, $data): bool
    {
        return add_metadata(
            static::MODEL,
            $entity->{static::ID_KEY},
            $this->metaKey,
            $data,
            $this->isUniqueValue
        );
    }

    /**
     *
     */
    protected function deleteData($entity)
    {
        $response = (bool) delete_metadata(
            static::MODEL,
            $entity->{static::ID_KEY},
            $this->metaKey,
            $this->getCurrentData($entity)
        );

        return $response;
    }
}
