<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */
?>

<div class="xtw-container">

    <h3><?php _e( 'XOOPS to WordPress Import', 'xtw' ) ?></h3>

    <div class="xtw-tabs">
        <form method="post" action="options.php">
			<?php settings_fields( 'xtw_options_group' ); ?>
			<?php do_settings_sections( 'xoops-to-wordpress-import' ); ?>
            <ul class="xtw-nav">
                <li>
                    <a class="xtw-tab-overview xwt-active" href="javascript:" title="<?php _e( 'Overview', 'xtw' ); ?>">
						<?php _e( 'Overview', 'xtw' ); ?>
                    </a>
                </li>

                <li>
                    <a class="xtw-tab-cpt" href="javascript:" title="<?php _e( 'Post Types', 'xtw' ); ?>">
						<?php _e( 'Post Types', 'xtw' ); ?>
                    </a>
                </li>

                <li>
                    <a class="xtw-tab-options" href="javascript:" title="<?php _e( 'Options', 'xtw' ); ?>">
						<?php _e( 'Options', 'xtw' ); ?>
                    </a>
                </li>

            </ul>

            <div class="xtw-tab  xtw-active-tab" id="xtw-tab-overview">
                <h4><?php _e( 'Overview', 'xtw' ); ?></h4>
				<?php XTW_Import::xtw_get_view( 'xtw_overview' ) ?>
            </div>

            <div class="xtw-tab" id="xtw-tab-cpt">
                <h4><?php _e( 'Post Types', 'xtw' ); ?></h4>

                <table class="xtw-option-table">
                    <tr>
                        <td colspan="2" class="table-head">Custom Post Types</td>
                    </tr>
					<?php echo XTW_Import::xtw_set_input( 'xtw_cpt_name', 'Post Type Name', 'text', '', '', false ); ?>
					<?php echo XTW_Import::xtw_set_input( 'submit', 'Save', 'submit', null, 'Submit' ); ?>
                </table>
            </div>

            <div class="xtw-tab" id="xtw-tab-options">
                <h4><?php _e( 'Options', 'xtw' ); ?></h4>

                <table class="xtw-option-table">
                    <tr>
                        <td colspan="2" class="table-head">General Options</td>
                    </tr>
					<?php echo XTW_Import::xtw_set_input( 'xtw_execute_time', 'Set max execution time to "0"', 'checkbox', null, '1' ); ?>
					<?php echo XTW_Import::xtw_set_input( 'submit', 'Save', 'submit', null, 'Submit' ); ?>
                </table>

            </div>
        </form>
    </div><!-- .xtw-tabs -->


    <div class="xtw-container-footer">
		<?php _e( 'XOOPS, thanks for the fishes, made with love by Angelo Rocha &hearts;', 'xtw' ); ?>
    </div>
</div><!-- .xtw-container -->