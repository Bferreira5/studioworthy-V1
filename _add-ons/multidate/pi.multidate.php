<?php
class Plugin_multidate extends Plugin {

	var $meta = array(
        'name'        => 'multidate',
        'description' => 'A multidate picker for Statamic',
        'version'     => '1.4',
        'docs'        => 'http://dirigible.us/add-ons/multidate',
        'author'      => '@thanland (Than Tibbetts)',
        'author_url'  => 'http://dirigible.us'
	);


	public function index() {

        $dates      = explode(",", $this->fetchParam('dates'));
        $format     = Config::get('date_format');
        $format     = $this->fetchParam('format', $format, null, FALSE, FALSE) ?: 'Y-m-d';
        $sort_dir   = $this->fetchParam('sort_dir', null, null, FALSE, FALSE);
        $after      = strtotime($this->fetchParam('after', null, null, FALSE, FALSE));
        $before     = strtotime($this->fetchParam('before', null, null, FALSE, FALSE));
        $showFuture = $this->fetchParam('show_future', true, null, TRUE, FALSE);
        $showPast   = $this->fetchParam('show_past', true, null, TRUE, FALSE);


        // Put everthing in timestamps for easier manipulation
        foreach ( $dates as $key => $date ) {

           $dates[$key] = strtotime($date);

        }

        // Sort the dates
        if ( $sort_dir == 'asc' ) {

            sort($dates);

        } else if ( $sort_dir == 'desc' ) {

            rsort($dates);

        }

        // Trim the array of dates with the requested limits
        if ( $after ) {
            $dates = $this->tasks->datesAfter( $dates, $after );
        }

        if ( $before ) {
            $dates = $this->tasks->datesBefore( $dates, $before );
        }

        if ( $showFuture == false ) {
            $dates = $this->tasks->datesBefore( $dates, time() );
        }

        if ( $showPast == false ) {
            $dates = $this->tasks->datesAfter( $dates, time() );
        }


        // Restore each date to its requested format
        foreach ( $dates as $key => $date ) {

           $dates[$key] = date($format, $date);

        }

        // Return the results as an array, which put them into their own internal tag pair
        $output = Array(
            "dates" => $dates
        );

        return $output;

	}

    public function form() {

        $id = $this->fetchParam('id', md5(microtime()), null, FALSE, FALSE);

        $attributes = array(
            'name' => $this->fetchParam('name', 'Multidate', null, FALSE, FALSE),
            'id' => $id,
            'class' => 'multidate',
            'value' => $this->fetchParam('value', '', null, FALSE, FALSE),
            'data-value' => $this->fetchParam('value', '', null, FALSE, FALSE)
        );

        // Hide the input field
        $attributes['class'] .= ' hidden';

        $dates = str_replace(',', '","', $attributes['value']);

        $html  = '<div class="field">';
        $html .= HTML::makeInput('text', $attributes);
        $html .= '<div class="" id="multidate-' . $attributes['id'] .'"></div>';
        $html .= '</div>';

        $html .= '<script>
                  var dates = ["' . $attributes['value'] .'"];
                  $(document).ready(function(){
                    $("#multidate-' . $attributes['id'] . '").datepicker({multidate:true});
                    $("#multidate-' . $attributes['id'] . '").datepicker("setDates",dates);
                    $("#multidate-' . $attributes['id'] . '").on("changeDate", function (e){
                      $("input#' . $attributes['id'] . '").val($("#multidate-' . $attributes['id'] . '").datepicker("getFormattedDate"));
                    });
                  });
                </script>';

        return $html;
    }


    public function head() {

        $includeJquery = $this->fetchParam('jquery', false, null, TRUE, FALSE);
        $includeCss = $this->fetchParam('css', true, null, TRUE, FALSE);
        $html = '';

        if ( $includeJquery ) {
            $html .= '<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>';
        }

        if ( $includeCss ) {
            $html .= $this->css->link('datepicker.css');
        }

        $html .= $this->js->link('multidate.js');

        return $html;

    }

}
