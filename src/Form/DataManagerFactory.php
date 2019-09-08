<?php

namespace Backalley\Form;

use Backalley\Form\Contracts\FieldDataManagerInterface;
use Backalley\Form\Contracts\MultiFieldDataManagerFactoryInterface;
use Backalley\Form\Managers\FieldDataManagerCallback;
use Backalley\GuctilityBelt\Concerns\SmartFactoryTrait;
use Exception;
use Illuminate\Support\Collection;

class DataManagerFactory implements MultiFieldDataManagerFactoryInterface
{
    use SmartFactoryTrait;

    /**
     *
     */
    private $managers = [];

    /**
     *
     */
    protected $namespace = [];

    protected const NAMESPACE = [
        "Backalley\\Form\\DataManagers"
    ];

    protected const MANAGERS = [
        'callback' => FieldDataManagerCallback::class
    ];

    /**
     *
     */
    public function __construct()
    {
        foreach (static::NAMESPACE as $namespace) {
            $this->addNamespace($namespace);
        }
        foreach (static::MANAGERS as $arg => $manager) {
            $this->addManager($arg, $manager);
        }
    }

    /**
     * Get the value of managers
     *
     * @return mixed
     */
    public function getManagers()
    {
        return $this->managers;
    }

    /**
     * Set the value of managers
     *
     * @param mixed $managers
     *
     * @return self
     */
    public function addManager(string $arg, string $manager)
    {
        $this->managers[$arg] = $manager;

        return $this;
    }

    /**
     *
     */
    public function create(string $manager, array $args = []): FieldDataManagerInterface
    {
        $class = $this->getClass($manager);
        $args = Collection::make($args);

        if (isset($this->managers[$manager])) {
            $manager = $this->buildObject($this->managers[$manager], $args);
        } elseif (false !== $class) {
            $manager = $this->buildObject($class, $args);
        } else {
            throw new Exception("{$manager} is not a recognized field data manager");
        }

        return $manager;
    }

    /**
     *
     */
    protected function buildObject(string $class, Collection $args): FieldDataManagerInterface
    {
        return $this->build($class, $args);
    }
}
