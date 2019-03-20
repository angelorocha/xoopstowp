<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

$forum = new XTW_Forum();

$forum->xtw_get_forums();
$forum->xtw_get_topics();
$forum->xtw_get_replies();

#$forum->xtw_set_forums();
#$forum->xtw_set_topics();
#$forum->xtw_set_replies();

#tools.php?page=bbp-repair