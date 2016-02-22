<?php
class Hooks_limited extends Hooks {

  public function control_panel__add_to_head()
  {
    if (URL::getCurrent(false) == '/publish') {
      // Inject JS & CSS file to head
      $js = $this->js->link('wChar.min.js');
      $css = $this->css->link('limited.css');

      return $js . $css;
    }
  }

}
