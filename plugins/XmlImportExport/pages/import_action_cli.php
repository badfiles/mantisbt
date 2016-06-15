<?php
/**
 * MantisBT - A PHP based bugtracking system
 *
 * MantisBT is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * MantisBT is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @copyright Copyright 2002  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 */

/**
 * Process XML Import
 */

#exit( 0 );

global $g_bypass_headers;
$g_bypass_headers = 1;

require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/core.php' );

# Make sure this script doesn't run via the webserver
if( php_sapi_name() != 'cli' ) {
	echo "import_action_cli.php is not allowed to run through the webserver.\n";
	exit( 1 );
}

$t_plugin_path = config_get( 'plugin_path' );
require_once( $t_plugin_path . 'XmlImportExport/ImportXml.php' );

auth_attempt_script_login( '1c' );

$f_file = 'file:///srv/ftp/out.xml';
$f_strategy = 'renumber';
$f_fallback = 'disable';
$f_keepcategory = true;
$f_defaultcategory = '';

$t_importer = new ImportXML( $f_file, $f_strategy, $f_fallback, $f_keepcategory, $f_defaultcategory );
$t_importer->import( );

exit( 0 );
