<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResourceAvailabilityRequest;
use App\Repositories\ResourceRepository;

class ResourceController extends Controller
{
    private $resourceRepository;

    public function __construct(ResourceRepository $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
    }

    /**
     * The index function retrieves all resources and returns a JSON response based on the result
     *
     * @return The `index` function returns a JSON response with status code 200 and data if resources are
     * found, a JSON response with status code 404 and a message if no resources are found, and a simple
     * array with status code 500 and an error message if an internal error occurs.
     */
    public function index()
    {
        try {
            $allResources = $this->resourceRepository->all();

            if ($allResources->toArray()) {
                return response()->json(['status' => 200, 'mesagge' => 'Sucess', 'data' => $allResources], 200);
    
            } else {
                return response()->json(['status' => 404, 'message' => 'No resources found'], 404);
            }

        } catch (\Throwable $th) {
            return response()->json(['status' => 500,
            'message' => 'Internal error, contact administrator'], 500);
        }
    }

    /**
     * The function checks resource availability based on input data and returns corresponding messages.
     *
     * @param ResourceAvailabilityRequest request The `availability` function in your code snippet
     * handle resource availability based on the request data. Validates the request data and then checks
     * the availability status returned by the `getAvailability` method of the resource repository.
     *
     * @return The function `availability` returns a JSON response based on the value of the
     * `` variable.
     */
    public function availability(ResourceAvailabilityRequest $request)
    {
        $validateData = $request->validated();

        try {
            $resourceAvailability = $this->resourceRepository->getAvailability($validateData);

            if ($resourceAvailability == 'true') {
                return response()->json(['status' => 200, 'message' => 'You can make the reservation'], 200);

            } elseif ($resourceAvailability == "Invalid time") {
                return response()->json(['status' => 400,
                    'message' => 'Reservations are only possible from 8:00 to 16:00'], 400);

            } elseif ($resourceAvailability == "Invalid resource") {
                return response()->json(['status' => 404,
                'message' => 'the resource does not exist'], 404);

            } elseif ($resourceAvailability == "Invalid date") {
                return response()->json(['status' => 400,
                'message' => 'There is already a reservation on that date'], 400);
            }
        
        } catch (\Throwable $th) {
            return response()->json(['status' => 500,
            'message' => 'Internal error, contact administrator'], 500);
        }
    }
    
}
