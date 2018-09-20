<?php

namespace Drupal\event_timer;
use Drupal\Core\Datetime\DrupalDateTime;


/**
 * This event timer service will parse the event date
 * Class EventTimerService
 * @package Drupal\event_timer
 */
class EventTimerService {

    public static function getHumanDateDifferenceForEvent(DrupalDateTime $date) {

        $today = new DrupalDateTime();
        $diff = $today->diff($date);

        $days = $diff->days * ($diff->invert ? -1 : 1);
        $hours = $diff->h * ($diff->invert ? -1 : 1);
        $minutes = $diff->m * ($diff->invert ? -1 : 1);

        if($days > 0) {

            return "Event starts in: " . $days . " days & " . $hours. " hours";

        } else if($days == 0 && ($hours > 0 || $minutes > 0)) {

            return ($hours == 0 && $minutes < 15 ? "Event is currently in progress." : "Event is starting soon (in ".$hours." hours) - hurry up, you can still make it Forest!");

        } else {

            return "The event has already passed kind sir!";
        }
    }
}