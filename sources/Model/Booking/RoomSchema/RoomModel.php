<?php

namespace Model\Booking\RoomSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use Model\Booking\RoomSchema\AutoStructure\Room as RoomStructure;
use Model\Booking\RoomSchema\Room;

/**
 * RoomModel
 *
 * Model class for table room.
 *
 * @see Model
 */
class RoomModel extends Model
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
        $this->structure = new RoomStructure;
        $this->flexible_entity_class = '\Model\Booking\RoomSchema\Room';
    }
}
