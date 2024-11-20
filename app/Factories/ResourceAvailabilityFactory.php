<?php

namespace App\Factories;

use App\Models\Reservation;
use App\Models\Resource;
use DateInterval;
use DateTime;

class ResourceAvailabilityFactory
{

/**
 * The function `processAvailability` checks if a reservation is within working hours and if a resource
 * exists before determining reservation availability.
 *
 * @return The `processAvailability` function returns either 'Invalid resource' if the resource does
 * not exist, or 'Invalid time' if the reservation is not within the specified working hours. If the
 * conditions are met, it calls the `reservationAvailability` method with certain parameters and
 * returns the result of that method.
 */
    public function processAvailability(array $params)
    {
        $reserve = new DateTime($params['reserve']);
        $startTime = new DateTime($reserve->format('Y-m-d') . ' 08:00:00');
        $endTime = new DateTime($reserve->format('Y-m-d') . ' 16:00:00');

        // Si la reserva está en horario laboral
        if ($reserve >= $startTime && $reserve <= $endTime) {
            $resourceExists = Resource::find($params['id']);

            // Si existe el recurso
            if ($resourceExists) {
                //Si hay reservas existentes para el recurso
                $reservationExists = Reservation::where('resources_id', $params['id'])->get()->toArray();
                return $this->reservationAvailability($reservationExists, $params, $reserve, $resourceExists);

            } else {
                return 'Invalid resource';
            }

        } else {
            return 'Invalid time';
        }
    }

    /**
     * The function `reservationAvailability` checks if a new reservation can be made based on existing
     * reservations for a resource.
     *
     * @param reservationExists These are all existing reservations.
     * @param params These are all existing reservations.
     * @param reserve It is the date of the new reservation
     * @param resourceExists It is the resource, join to bring your capacity or availability number.
     *
     * @return If the conditions inside the `reservationAvailability` function are met, it will return
     * either `'Invalid date'` if the number of reservations exceeds the capacity of the resource, or
     * `true` if the reservation is valid. If there are no existing reservations for the resource, it will
     * also return `true`.
     */
    public function reservationAvailability($reservationExists, $params, $reserve, $resourceExists)
    {
        if ($reservationExists) {
            $reserveDate = $reserve->format('Y-m-d');
            $numberReservations = 0;

            // Calcular la hora final de la nueva reserva
            $durationParts = explode(':', $params['duration']);
            $reserveEndTime = clone $reserve;
            $reserveEndTime->add(new DateInterval(
                'PT' . $durationParts[0] . 'H' . $durationParts[1] . 'M' . $durationParts[2] . 'S'
            ));

            foreach ($reservationExists as $reservation) {
                $reservedDB = date('Y-m-d', strtotime($reservation['reserved_at']));

                // Si las reservas son en el mismo día
                if ($reserveDate === $reservedDB) {
                    $reservedStartTime = new DateTime($reservation['reserved_at']);
                    $reservedEndTime = clone $reservedStartTime;

                    // Calcular la hora final de la reserva existente
                    $existingDurationParts = explode(':', $reservation['duration']);
                    $reservedEndTime->add(new DateInterval(
                        'PT' . $existingDurationParts[0] . 'H' . $existingDurationParts[1] . 'M' . $existingDurationParts[2] . 'S'
                    ));

                    if (
                        //Si la hora de inicio a reservar cae dentro del rango de una reserva
                        ($reserve >= $reservedStartTime && $reserve <= $reservedEndTime) ||
                        //Si la hora final a reservar cae dentro del rango de una reserva
                        ($reserveEndTime >= $reservedStartTime && $reserveEndTime <= $reservedEndTime) ||
                        //Si el rango completo a reservar cubre el rango completo de una reserva
                        ($reserve <= $reservedStartTime && $reserveEndTime >= $reservedEndTime)
                    ) {
                        $numberReservations++;
                        if ($numberReservations >= $resourceExists['capacity']) {
                            return 'Invalid date';
                        }
                    }
                }
            }
            return true;

        } else {
            // Si no hay reservas existentes para el recurso
            return true;
        }
    }
}