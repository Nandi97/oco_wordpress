<?php


namespace Pluginator\Examples\Upgrade_Example;

// if (!defined('ABSPATH')) {
//     exit; // Exit if accessed directly.
// }

if (!class_exists('\Pluginator\Examples\Upgrade_Example\Upgrade_List')) {
    class Upgrade_List
    {

        public function  get_upgrades()
        {
            $upgrades = [
                '0.2' => 'upgrade_v02',
            ];

            return $upgrades;
        }
    } // END CLASS
}
