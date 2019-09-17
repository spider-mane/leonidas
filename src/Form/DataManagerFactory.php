<?php

namespace Backalley\Form;

use Backalley\Form\Contracts\FieldDataManagerInterface;
use Backalley\Form\Contracts\MultiFieldDataManagerFactoryInterface;
use Backalley\Form\Managers\FieldDataManagerCallback;
use Backalley\GuctilityBelt\Concerns\ClassResolverTrait;
use Backalley\GuctilityBelt\Concerns\SmartFactoryTrait;
use Exception;
use Illuminate\Support\Collection;

class DataManagerFactory implements MultiFieldDataManagerFactoryInterface
{
    use SmartFactoryTrait;
    use ClassResolverTrait;

    /**
     *
     */
    private $managers = [];

    /**
     *
     */
    protected $namespaces = [];

    public const NAMESPACES = [
        'webtheory.form' => __NAMESPACE__ . "\\DataManagers",
    ];

    public const MANAGERS = [
        'callback' => FieldDataManagerCallback::class
    ];

    protected const CONVENTION = '%sFieldDataManager';

    /**
     *
     */
    public function __construct(array $namespaces = [], array $managers = [])
    {
        $this->namespaces = $namespaces + static::NAMESPACES;
        $this->managers = $managers + static::MANAGERS;
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
    public function addManagers(array $managers)
    {
        $this->managers = $managers + $this->managers;

        return $this;
    }

    /**
     *
     */
    public function create(string $manager, array $args = []): FieldDataManagerInterface
    {
        $args = Collection::make($args);

        if (isset($this->managers[$manager])) {
            $manager = $this->buildObject($this->managers[$manager], $args);
        } elseif ($class = $this->getClass($manager)) {
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
