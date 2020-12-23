<?php
/*
Plugin Name: HTML Widget Text
Plugin URI: https://jabelone.com.au
Version: 1.01
Author: <a href="https://jabelone.com.au">Jaimyn Mayer</a>
Description: Lets you use HTML in widget titles.  Simply replace < and > in the html tag with [ and ] to use.

*/
/*  Copyright 2016  Jaimyn Mayer  (email: admin@jabelone.com.au)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
//  To view the full license you can also visit this link: http://www.gnu.org/copyleft/gpl.html

defined('ABSPATH') or die("No script kiddies please!");

add_filter( 'widget_title', 'html_widget_title_replace' ); //Uses the built in filter function.  The title of the widget is passed to the function.

function html_widget_title_replace($html_widget_title) {

	$html_widget_title_tagopen = '['; //Our HTML opening tag replacement
	$html_widget_title_tagclose = ']'; //Our HTML closing tag replacement

	$html_widget_title = str_replace($html_widget_title_tagopen, '<', $html_widget_title);
	$html_widget_title = str_replace($html_widget_title_tagclose, '>', $html_widget_title);

	return $html_widget_title;
}

?>