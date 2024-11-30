<?php

namespace App\DTO;

class BookingDTO{
    public $bookingId, $bookingAgenda, $bookingDate, $bookingTimeStart, $bookingTimeFinish;
    public $userbookingName;
    public $roomName;

    public function __construct($bookingId, $bookingAgenda, $bookingDate, $bookingTimeStart, $bookingTimeFinish, $userbookingName, $roomName) {
        $this->bookingId = $bookingId;
        $this->bookingAgenda = $bookingAgenda;
        $this->bookingDate = $bookingDate;
        $this->bookingTimeStart = $bookingTimeStart;
        $this->bookingTimeFinish = $bookingTimeFinish;
        $this->userbookingName = $userbookingName;
        $this->roomName = $roomName;
    }

}
