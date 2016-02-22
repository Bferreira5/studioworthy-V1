<?php

/*
 *
 * Limited: A character limited textarea
 * Built with wChar.js: http://wchar.websanova.com/
 * Usage (in fieldset yaml):
 *
 *      fieldname:
 *          display: Display Name
 *          type: limited
 *          limit: 180
 *
*/

class Fieldtype_limited extends Fieldtype {

  var $meta = array(
    'name'       => 'Limited',
    'version'    => '0.2',
    'author'     => 'Luke Mitchell',
    'author_url' => 'http://www.interroban.gg'
  );

  static $field_settings;

  // Display instructions
  function render_instructions_above() {
    $limit = isset($this->field_config['limit']) ? $this->field_config['limit'] : '50';

    return " (limited to {$limit} characters)";
  }

  // Render the field
  public function render() {

    self::$field_settings = $this->field_config;

    // Get limit from field yaml file. Defaults to 50.
    $limit = isset($this->field_config['limit']) ? $this->field_config['limit'] : '50';

    // HTML output
    $html = "

    <div class='limited-container input-block input-textarea'>
      <textarea class='limited' style='height: 150px;' name='{$this->fieldname}' tabindex='{$this->tabindex}' data-maxlength='{$limit}'>$this->field_data</textarea>
      <script>
        $('textarea.limited').wChar({
            message: 'left',
            messageMin: 'to go',
            position: 'tr'
        });
      </script>
    </div>

    ";

    return $html;
  }

  public static function get_field_settings() {
    return self::$field_settings;
  }

  function process() {
    return $this->field_data;
  }

}
