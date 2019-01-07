<strong><?php _e( 'Server Details', 'xtw' ); ?></strong>
<ul>
    <li>
		<?php
		_e( 'Memory Limit: ', 'xtw' );
		echo XTW_Options::xtw_get_memory_limit();
		?>
    </li>
    <li>
		<?php
		_e( 'Max Execution Time: ', 'xtw' );
		echo XTW_Options::xtw_get_time_limit();
		?>
    </li>
</ul>

<strong><?php _e( 'XOOPS Data', 'xtw' ) ?></strong>
<ul>
    <li>
		<?php
		$xoopsURL = XTW_XoopsUrl::xtw_xoops_home_url();
		_e( 'XOOPS URL: ', 'xtw' );
		echo "<a href='$xoopsURL' title='$xoopsURL' target='_blank'>$xoopsURL</a>";
		?>
    </li>
    <li>
		<?php
		_e( 'Instaled Modules: ', 'xtw' );
		?>
    </li>
</ul>