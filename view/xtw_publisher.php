<?php
/**
 * XOOPS To WordPress Plugin
 * Created by Angelo Rocha
 * Contact: contato@angelorocha.com.br
 * Site: www.angelorocha.com.br
 */

$publisherCats = new XTW_PublisherCats();
$publisherCats->xtw_publisher_get_cats();
#$publisherCats->xtw_publisher_set_cats();

$publisher = new XTW_Publisher();
$publisher->xtw_get_publisher_itens();
#$publisher->xtw_set_publisher_itens();