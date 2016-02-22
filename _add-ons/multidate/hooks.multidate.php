<?php
class Hooks_multidate extends Hooks {

  public function control_panel__add_to_head() {

    if (URL::getCurrent(false) == '/publish') {

      return $this->css->link('multidate.css') . $this->js->link('multidate.js');

    }

  }

}