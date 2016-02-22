<?php
class Fieldtype_multidate extends Fieldtype {

  public function render() {

    $attributes = array(
      'name' => $this->fieldname,
      'id' => $this->field_id,
      'class' => 'multidate',
      'tabindex' => $this->tabindex,
      'value' => HTML::convertSpecialCharacters($this->field_data),
      'data-value' => HTML::convertSpecialCharacters($this->field_data),
    );

    $options['mode'] = array_get($this->field_config, 'mode', 'dropdown');


    /*
     *  Set up the dropdown Multidate field
     */

    if ($options['mode'] == 'dropdown') {

      $dates = str_replace(',', '","', $this->field_data);

      $html  = '<div class="field">';
      $html .=  "<span class='ss-icon'>date</span>";
      $html .= HTML::makeInput('text', $attributes, $this->is_required);
      $html .= '</div>';

      $html .= '<script>
                  var dates = ["' . $dates .'"];
                  $(document).ready(function(){
                    $("#' . $this->field_id . '").datepicker({multidate:true});
                    $("#' . $this->field_id . '").on("changeDate", function(e){
                      $(this).attr("size", $(this).val().length);
                    });
                  });
                </script>';

    /*
     *  Set up the inline Multidate field
     */

    } elseif ($options['mode'] == 'inline') {

      // Hide the input field
      $attributes['class'] .= ' hidden';

      $dates = str_replace(',', '","', $this->field_data);

      $html  = '<div class="field">';
      $html .= HTML::makeInput('text', $attributes, $this->is_required);
      $html .= '<div class="well" id="multidate-' . $this->field_id .'"></div>';
      $html .= '</div>';

      $html .= '<script>
                  var dates = ["' . $dates .'"];
                  $(document).ready(function(){
                    $("#multidate-' . $this->field_id . '").datepicker({multidate:true});
                    $("#multidate-' . $this->field_id . '").datepicker("setDates",dates);
                    $("#multidate-' . $this->field_id . '").on("changeDate", function (e){
                      $("input#' . $this->field_id . '").val($("#multidate-' . $this->field_id . '").datepicker("getFormattedDate"));
                    });
                  });
                </script>';

    }

    return $html;

  }

}