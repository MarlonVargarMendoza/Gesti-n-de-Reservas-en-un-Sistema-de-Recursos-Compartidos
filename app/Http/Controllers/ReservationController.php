<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationStoreRequest;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    private $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * @param Reservation reservation The `destroy` function is responsible for deleting a reservation. It
     * takes a `Reservation` object as a parameter. If the deletion is successful, it returns a JSON
     * response with a status of 200 and a success message. If the reservation was not found, it returns a
     * JSON response with a status
     */
    public function destroy(Reservation $reservation)
    {
        try {
            $deleteReservation = $this->reservationRepository->delete($reservation);
            
            if ($deleteReservation) {
                return response()->json(['status' => 200, 'mesagge' => 'Success'], 200);
    
            } else {
                return response()->json(['status' => 404, 'message' => 'was not found at the reservation'], 404);
            }

        } catch (\Throwable $th) {
            return response()->json(['status' => 500,
            'message' => 'Internal error, contact administrator'], 500);
        }
    }

    /**
     * @param ReservationStoreRequest request The `store` function you provided seems to handle storing
     * reservations based on the data received in the `ReservationStoreRequest` object. It validates the
     * request data, saves the reservation using a repository, and then returns a JSON response based on
     * the result of the save operation.
     *
     * @return The `store` function is returning a JSON response based on the result of creating a
     * reservation. Here is a summary of the possible return scenarios:
     */
    public function store(ReservationStoreRequest $request)
    {
        $validateData = $request->validated();

        try {
            $createReservation = $this->reservationRepository->save($validateData);
            
            if ($createReservation == 'true') {
                return response()->json(['status' => 200, 'message' => 'Reservation created'], 200);

            } elseif ($createReservation == "Invalid time") {
                return response()->json(['status' => 400,
                    'message' => 'Reservations are only possible from 8:00 to 16:00'], 400);

            } elseif ($createReservation == "Invalid resource") {
                return response()->json(['status' => 404,
                'message' => 'the resource does not exist'], 404);

            } elseif ($createReservation == "Invalid date") {
                return response()->json(['status' => 400,
                'message' => 'There is already a reservation on that date'], 400);

            }

        } catch (\Throwable $th) {
            return response()->json(['status' => 500,
            'message' => 'Internal error, contact administrator'], 500);
        }
    }

}
