<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

$tdmdownloadsCats = new XTW_TDMDownloadsCats();
$tdmdownloadsCats->xtw_get_tdmdownloads_cat();
#$tdmdownloadsCats->xtw_set_tdmdownloads_cat();

$tdmdownloads = new XTW_TDMDownloads();
$tdmdownloads->xtw_get_tdmdownloads();
#$tdmdownloads->xtw_set_tdmdownloads();
