<?php
/** Blog sidebar. @package TargetWeb3 */
if ( ! is_active_sidebar( 'sidebar-1' ) ) return;
?>
<aside class="tw3-sidebar">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
