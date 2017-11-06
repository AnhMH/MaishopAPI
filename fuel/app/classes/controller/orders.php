<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Controller_Orders extends \Controller_App {
    /**
     * Add
     */
    public function action_add() {
        return \Bus\Orders_GetInfo::getInstance()->execute();
    }
}