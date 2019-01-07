<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

$wflinksCats = new XTW_WFLinksCats();
$wflinksCats->xtw_get_wflinks_cats();
#$wflinksCats->xtw_set_wflinks_cats();

$wflinks = new XTW_WFLinks();
$wflinks->xtw_get_wflinks_items();
#$wflinks->xtw_set_wflinks_items();
