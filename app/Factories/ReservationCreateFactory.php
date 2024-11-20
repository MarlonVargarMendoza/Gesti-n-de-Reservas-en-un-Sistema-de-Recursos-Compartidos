<?php

namespace App\Factories;

class ReservationCreateFactory {

/**
 * The function `processReservation` creates a new reservation based on the provided parameters and
 * then processes its availability using a ResourceAvailabilityFactory.
 *
 * @param array params resources_id, reserved_at, duration
 *
 * @return The `processReservation` function is returning the result of calling the
 * `processAvailability` method on a new instance of the `ResourceAvailabilityFactory` class, passing
 * in the `` array as a parameter.
 */
    public function processReservation(array $params)
    {
        $newReservation  = [
            'id' => $params['resources_id'],
            'reserve' => $params['reserved_at'],
            'duration' => $params['duration']
        ];

        $availability = new ResourceAvailabilityFactory;
        return $availability->processAvailability($newReservation);
    }
}