<?php

namespace App\Repositories;

use App\Factories\ResourceAvailabilityFactory;
use App\Models\Resource;

class ResourceRepository extends BaseRepository {

    private $resourceAvailabilityFactory;

    /**
     * The function is a constructor that takes a Resource object as a parameter and calls the parent
     * constructor with that object.
     * 
     * @param Resource resource The `Resource` parameter in the constructor is likely an object
     * representing a resource that the class needs to work with or manipulate. It could be a file,
     * database connection, network resource, or any other type of resource that the class depends on. By
     * passing this resource to the constructor and then calling the
     */
    public function __construct(Resource $resource, ResourceAvailabilityFactory $resourceAvailabilityFactory)
    {
        parent::__construct($resource);
        $this->resourceAvailabilityFactory = $resourceAvailabilityFactory;
    }

    /**
     * The getAvailability function in PHP processes availability using resourceAvailabilityFactory.
     *
     * @return The `getAvailability` function is returning the result of calling the `processAvailability`
     * method on the `resourceAvailabilityFactory` object with the provided `` array.
     */
    public function getAvailability(array $params)
    {
        return $this->resourceAvailabilityFactory->processAvailability($params);
    }

}
