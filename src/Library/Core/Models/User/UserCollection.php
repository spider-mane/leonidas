<?php

namespace Leonidas\Library\Core\Models\User;

use Leonidas\Library\Core\Models\AbstractWpModelCollection;
use WP_User;

class UserCollection extends AbstractWpModelCollection
{
    /**
     * @var WP_User
     */
    protected $users;

    /**
     *
     */
    protected const ID_KEY = '';

    /**
     *
     */
    protected const NAME_KEY = '';

    /**
     *
     */
    protected const SLUG_KEY = '';

    /**
     *
     */
    protected const OBJECT_TYPE = '';

    /**
     *
     */
    protected const COLLECTION = 'users';

    /**
     *
     */
    public function getUsers()
    {
        return $this->getCollection();
    }

    /**
     *
     */
    public function without(UserCollection $collection)
    {
        return parent::without($collection);
    }
}
