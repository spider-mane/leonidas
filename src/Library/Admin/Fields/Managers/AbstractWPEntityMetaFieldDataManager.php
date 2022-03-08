<?php

namespace Leonidas\Library\Admin\Fields\Managers;

use Psr\Http\Message\ServerRequestInterface;
use WebTheory\Saveyour\Contracts\FieldDataManagerInterface;

abstract class AbstractWPEntityMetaFieldDataManager implements FieldDataManagerInterface
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

    public function __construct(string $metaKey)
    {
        $this->metaKey = $metaKey;
    }

    public function getCurrentData(ServerRequestInterface $request)
    {
        $entity = $request->getAttribute(static::MODEL);

        return get_metadata(
            static::MODEL,
            $entity->{static::ID_KEY} ?? null,
            $this->metaKey,
            $this->isUniqueValue
        );
    }

    public function handleSubmittedData(ServerRequestInterface $request, $data): bool
    {
        $entity = $request->getAttribute(static::MODEL);

        $response = (bool) update_metadata(
            static::MODEL,
            $entity->{static::ID_KEY},
            $this->metaKey,
            $data,
            $this->getCurrentData($request)
        );

        return $response;
    }

    protected function createData($entity, $data): bool
    {
        return add_metadata(
            static::MODEL,
            $entity->{static::ID_KEY},
            $this->metaKey,
            $data,
            $this->isUniqueValue
        );
    }

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
