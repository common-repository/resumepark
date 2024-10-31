<?php
/*
Plugin Name: ResumePark
Plugin URI: http://www.resumepark.com/wp-plugin
Description: Embed your resume/cv into a blog post
Version: 1.0
Author: ResumePark
Author URI: http://www.resumepark.com	

Copyright 2009 ResumePark  (email : support@resumepark.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function rp_embed($content)
{
	$content = preg_replace_callback("/\[resumepark ([^]]*)\/\]/i", "rp_render", $content);
	return $content;
}

function rp_render($matches)
{
	
	$matches[1] = str_replace(array('&#8221;','&#8243;'), '', $matches[1]);
	preg_match_all('/(\w*)=(.*?) /i', $matches[1], $attributes);
	
	$arguments = array();

	foreach ( (array) $attributes[1] as $key => $value ) {
		$arguments[$value] = $attributes[2][$key];
	}
	
	$output = '';

	if (array_key_exists('resumeId', $arguments))
	{
		
		$resumeId = $arguments['resumeId'];
		$resumeargs = explode("!", $resumeId);
		
		$height= '500';
		$width= '690';

		if (array_key_exists('height', $arguments))
			$height= $arguments['height'];
	
		if (array_key_exists('width', $arguments))
			$width= $arguments['width'];

		$output = '<script type="text/javascript">var docGuid="'.$resumeargs[0].'"; var folder="'.$resumeargs[1].'"; var h = "'.$height.'px"; var w="'.$width.'px"; var c="646F74";</script>'."\n";
		$output .= '<script src="http://content.resumepark.com/scripts/rp-embed-resume.js" type="text/javascript"></script>'."\n";	
	}
	return $output;

}


add_filter('the_content', 'rp_embed');

?>