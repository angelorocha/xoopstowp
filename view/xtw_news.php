<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

$newsCats = new XTW_NewsCats();
$newsCats->xtw_get_news_topics();
#$newsCats->xtw_set_news_topics();

$news = new XTW_News();
$news->xtw_get_news();
#$news->xtw_set_news();