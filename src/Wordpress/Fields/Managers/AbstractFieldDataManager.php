<?php

namespace Backalley\WordPress\Fields\Managers;

use Backalley\WordPress\Fields\Contracts\DataFieldInterface;



abstract class AbstractFieldDataManager
{
    /**
     * @var DataFieldInterface
     */
    protected $field;

    /**
     * filter
     *
     * @var string
     */
    protected $filter = 'sanitize_text_field';

    /**
     *
     */
    public function setField(DataFieldInterface $field)
    {
        $this->field = $field;
    }
}
