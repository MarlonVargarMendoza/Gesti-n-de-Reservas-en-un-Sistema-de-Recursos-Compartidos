<?php

namespace App\Repositories;

use App\Factories\ReservationCreateFactory;
use App\Factories\ResourceAvailabilityFactory;
use App\Models\Reservation;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;

class ReservationRepository extends BaseRepository {

    private $reservationCreateFactory;

    /**
     * The above PHP function is a constructor that takes a Reservation object as a parameter and calls the
     * parent constructor with that object.
     * 
     * @param Reservation reservation The `__construct` method is a constructor in PHP that is called when
     * an object is created. In this case, the constructor takes a parameter of type `Reservation` and
     * assigns it to the parent class constructor using `parent::__construct()`. This means
     * that the parent class constructor is being
     */
    public function __construct(Reservation $reservation, ReservationCreateFactory $reservationCreateFactory)
    {
        parent::__construct($reservation);
        $this->reservationCreateFactory = $reservationCreateFactory;
    }
    

/**
 * The `save` function processes a reservation and saves it if successful, otherwise returns the
 * result.
 *
 * @return If the result of the `processReservation` method is equal to the string `'true'`, then a new
 * `Reservation` object is created using the provided parameters and the `save` method is called on
 * this object. If the result is not equal to `'true'`, then the result itself is returned.
 */
    public function save(array $params)
    {
        $result = $this->reservationCreateFactory->processReservation($params);
        
        if ($result == 'true') {
            $params = new Reservation($params);
            return $params->save();

        } else {
            return $result;
        }
    }
    
}