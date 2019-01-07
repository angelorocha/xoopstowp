<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

$partnersCats = new XTW_PartnersCat();

$partnersCats->xtw_get_partners_cat();
#$partnersCats->xtw_set_partners_cat();

$partners = new XTW_Partners();
$partners->xtw_get_partners();
#$partners->xtw_set_partners();