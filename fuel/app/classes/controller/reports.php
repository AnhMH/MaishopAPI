<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Reports extends \Controller_App {
    /**
     * Add/update info
     */
    public function action_general() {
        return \Bus\Reports_General::getInstance()->execute();
    }
}