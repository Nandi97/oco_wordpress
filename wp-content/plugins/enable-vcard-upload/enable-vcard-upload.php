<?php

/*************************************************************************

Plugin Name: Enable vCard Upload
Plugin URI: http://www.56degrees.co.uk/
Description: Enables upload of vCard (vcf) files.
Version: 1.1
Author: 56 Degrees Design
Author URI: hhttp://www.56degrees.co.uk/
Text Domain: enable-vcard-upload
Domain Path: /lang/

**************************************************************************/

/*************************************************************************

Copyright (C) 2016 56 Degrees Design

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

**************************************************************************/

if ( !defined( 'ABSPATH' ) ) {
	exit;
}


class EnableVcardUpload {

	/**
	 * Construct the plugin object
	 * @since    1.0.0
	 */
	public function __construct() {
		add_filter('upload_mimes', array( &$this, 'upload_mimes') );
	} // END public function __construct

	/**
	 * Activate the plugin
	 */
	public static function activate() {
		// Do nothing
	} // END public static function activate

	/**
	 * Deactivate the plugin
	 */
	public static function deactivate() {
		// Do nothing
	} // END public static function deactivate

	/**
	 * Add vcf supprt
	 * @since 1.0.0
	 */
	public function upload_mimes ( $mimes=array() ){
		$mimes['vcf'] = 'text/x-vcard';
		return $mimes;
	}
}


$GLOBALS['EnableVcardUpload'] = new EnableVcardUpload();
