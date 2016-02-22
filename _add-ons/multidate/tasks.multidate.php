<?php

class Tasks_multidate extends Tasks {

    /**
     * Removes dates after the specified date
     *
     * @param array  $dates  Array of dates from Multidate fieldtype
     * @param int   $after  Timestamp of after date
     * @return array
     **/
    public function datesAfter($dates, $after) {

        foreach ( $dates as $key => $date ) {

            if ( $date > $after ) {

                $newDates[$key] = $date;

            }

        }

        return $newDates;

    }

    /**
     * Removes dates before the specified date
     *
     * @param array  $dates  Array of dates from Multidate fieldtype
     * @param int   $before  Timestamp of before date
     * @return array
     **/
    public function datesBefore($dates, $before) {

        foreach ( $dates as $key => $date ) {

            if ( $date < $before ) {

                $newDates[$key] = $date;

            }

        }

        return $newDates;

    }

}