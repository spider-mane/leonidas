<?php

namespace WebTheory\Leonidas\Library\Core\Util;

use WP_User;

class UserCollection extends AbstractWpObjectCollection
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
