<?php
# MantisBT - A PHP based bugtracking system

# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Toggle passed file property
 *
 * @package MantisBT
 * @copyright Copyright 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright 2002  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 *
 * @uses core.php
 * @uses access_api.php
 * @uses bug_api.php
 * @uses config_api.php
 * @uses file_api.php
 * @uses form_api.php
 * @uses gpc_api.php
 * @uses helper_api.php
 * @uses lang_api.php
 * @uses print_api.php
 */

require_once( 'core.php' );
require_api( 'access_api.php' );
require_api( 'bug_api.php' );
require_api( 'config_api.php' );
require_api( 'file_api.php' );
require_api( 'form_api.php' );
require_api( 'gpc_api.php' );
require_api( 'helper_api.php' );
require_api( 'lang_api.php' );
require_api( 'print_api.php' );

$f_action = gpc_get_string( 'action' );

if( $f_action == 'l' ) {
    $t_access = 'handle_protected';
    $t_field = 'protected';
} else {
    $t_access = 'send';
    $t_field = 'to_send';
}

form_security_validate( 'bug_file_' . $t_field . '_toggle' );
$f_file_id = gpc_get_int( 'file_id' );
$t_bug_id = file_get_field( $f_file_id, 'bug_id' );
access_ensure_bug_level( config_get(  $t_access . '_attachments_threshold' ), $t_bug_id );
file_set_field( $f_file_id, $t_field, !(bool)file_get_field( $f_file_id, $t_field ) );
form_security_purge( 'bug_file_' . $t_field . '_toggle' );
print_header_redirect_view( $t_bug_id );
