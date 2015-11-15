<?php

namespace Model\Booking\RoomSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use Model\Booking\RoomSchema\AutoStructure\Booking as BookingStructure;
use Model\Booking\RoomSchema\Booking;

/**
 * BookingModel
 *
 * Model class for table booking.
 *
 * @see Model
 */
class BookingModel extends Model
{
    use WriteQueries;

    /**
     * __construct()
     *
     * Model constructor
     *
     * @access public
     */
    public function __construct()
    {
        $this->structure = new BookingStructure;
        $this->flexible_entity_class = '\Model\Booking\RoomSchema\Booking';
    }
}
