<?php
/**
 * Additional Shortcodes
 */


/********************************************************************************/
/* Google Charts */
/********************************************************************************/
function sc_gchart( $atts ) {
	extract(shortcode_atts(array(
			'id'	=>	'gchart_div',
			'style'	=>	'',
	), $atts));

	$styledata = '';
	if ( $style != '' ) {
		$styledata = ' style="'.$style.'"';
	}

	return '<div id="'.$id.'"'.$styledata.'></div>';
}

add_shortcode( 'gchart', 'sc_gchart' );


/********************************************************************************/
/* Timeliner */
/********************************************************************************/
function sc_timeline( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'style'	=>	'',
	), $atts));

	$styledata = '';
	if ( $style != '' ) {
		$styledata = ' style="'.$style.'"';
	}

	$content = do_shortcode( $content );
	$ret  = '';
	$ret .= '<div id="timelineContainer"'.$styledata.'>';
	$ret .= '<div class="timelineToggle">';
	$ret .= '<small><a class="expandAll expandAllclosed"></a></small>';
	$ret .= '</div>';
	$ret .= '<br class="clear" />'.$content.'<br class="clear" />';
	$ret .= '</div>';
	return $ret;
}

add_shortcode( 'timeline', 'sc_timeline' );


function sc_timeline_group( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'title'	=>	'',
			'tag'	=>	'h2',
	), $atts));

	$content = do_shortcode( $content );
	$ret  = '';
	$ret .= '<div class="timelineMajor">';
	$ret .= '<'.$tag.' class="timelineMajorMarker"><span><a>'.$title.'</a></span></'.$tag.'>';
	$ret .= $content;
	$ret .= '</div>';
	return $ret;
}

add_shortcode( 'timeline_group', 'sc_timeline_group' );


function sc_timeline_event( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'id'	=>	'',
			'title'	=>	'',
			'event'	=>	'',
			'tag'	=>	'',
	), $atts));

	$eventTag = '';
	if ( $tag != '' ) {
		$eventTag = '<'.$tag.'>'.$event.'</'.$tag.'>';
	}

	$content = do_shortcode( $content );
	$ret  = '';
	$ret .= '<dl class="timelineMinor">';
	$ret .= '<dt id="'.$id.'">';
	$ret .= '<a>'.$title.'</a>';
	$ret .= '<small id="'.$id.'DT" class="timelineEventDT">'.$event.'</small>';
	$ret .= '</dt>';
	$ret .= '<dd id="'.$id.'EX" class="timelineEvent" style="display: none;">';
	$ret .= $eventTag;
	$ret .= $content;
	$ret .= '</dd>';
	$ret .= '</dl>';
	return $ret;
}

add_shortcode( 'timeline_event', 'sc_timeline_event' );


function sc_timeline_event_single( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'event'	=>	'',
			'tag'	=>	'h3',
			'desc'	=>	'',
	), $atts));

	$eventTag = '';
	if ( $tag != '' ) {
		$eventTag = '<'.$tag.'>'.$event.'</'.$tag.'>';
	}
	$descTag = '';
	if ( $desc != '' ) {
		$descTag = '<p class="desc">'.$desc.'</p>';
	}

	$content = do_shortcode( $content );
	$ret  = '';
	$ret .= '<dl class="timelineMinor">';
	$ret .= '<dd>';
	$ret .= $eventTag;
	$ret .= $content;
	$ret .= $descTag;
	$ret .= '</dd>';
	$ret .= '</dl>';
	return $ret;
}

add_shortcode( 'timeline_event_single', 'sc_timeline_event_single' );


function sc_timeline_media( $atts, $content = null ) {
	extract(shortcode_atts( array(
			'style'	=>	'',
	), $atts));

	$styledata = '';
	if ( $style != '' ) {
		$styledata = ' style="'.$style.'"';
	}

	$content = do_shortcode( $content );
	$ret  = '';
	$ret .= '<div class="media"'.$styledata.'>';
	$ret .= $content;
	$ret .= '</div>';
	return $ret;
}

add_shortcode( 'timeline_media', 'sc_timeline_media' );


function sc_timeline_gallery( $atts ) {
	extract(shortcode_atts(array(
			'url'	=>	'',
			'title'	=>	'',
			'cred'	=>	'',
			'desc'	=>	'',
			'rel'	=>	'shadowbox[timeline]',
	), $atts));

	$ret = '';
	if ( $url != '' ) {
		$credTag = '';
		if ( $cred != '' ) {
			$credTag = '<p class="cred"><small>'.$cred.'</small></p>';
		}
		$descTag = '';
		if ( $desc != '' ) {
			$descTag = '<p class="desc">'.$desc.'</p>';
		}

		$ret = '';
		$ret .= '<div class="gallery default">';
		$ret .= '<div class="gallery-icon">';
		$ret .= '<a href="'.$url.'" rel="'.$rel.'">';
		$ret .= '<img title="'.$title.'" src="'.$url.'" alt="" />';
		$ret .= '</a>';
		$ret .= '</div>';
		$ret .= '</div>';
		$ret .= $credTag;
		$ret .= $descTag;
	}
	return $ret;
}

add_shortcode( 'timeline_gallery', 'sc_timeline_gallery' );


function sc_timeline_embed( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'cred'	=>	'',
			'desc'	=>	'',
	), $atts));

	$credTag = '';
	if ( $cred != '' ) {
		$credTag = '<p class="cred"><small>'.$cred.'</small></p>';
	}
	$descTag = '';
	if ( $desc != '' ) {
		$descTag = '<p class="desc">'.$desc.'</p>';
	}

	$content = do_shortcode( $content );
	$ret  = '';
	$ret .= '<div>';
	$ret .= $content;
	$ret .= '</div>';
	$ret .= $credTag;
	$ret .= $descTag;
	return $ret;
}

add_shortcode( 'timeline_embed', 'sc_timeline_embed' );


function sc_timeline_infolist( $atts ) {
	extract(shortcode_atts(array(
			'list'	=>	'',
			'delim'	=>	'::::',
	), $atts));

	$liTag = '';
	if ( $list != '' ) {
		$array = explode( $delim, $list );
		$count = count( $array );
		for ( $i = 0; $i < $count; $i++ ) {
			$liTag .= '<li>'.$array[$i].'</li>';
		}
	}

	$ret  = '';
	$ret .= '<ul class="moreInfo">';
	$ret .= $liTag;
	$ret .= '</ul>';
	return $ret;
}

add_shortcode( 'timeline_infolist', 'sc_timeline_infolist' );


/********************************************************************************/
/* Google Maps Column */
/********************************************************************************/
function sc_map_column( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'style'	=>	'',
	), $atts));

	$styledata = '';
	if ( $style != '' ) {
		$styledata = ' style="'.$style.'"';
	}

	$content = do_shortcode( $content );
	$ret  = '';
	$ret .= '<div id="mapcontainer"'.$styledata.'>';
	$ret .= $content;
	$ret .= '</div>';
	return $ret;
}

add_shortcode( 'map_column', 'sc_map_column' );


function sc_map_location( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'style'	=>	'',
	), $atts));

	$styledata = '';
	if ( $style != '' ) {
		$styledata = ' style="'.$style.'"';
	}

	$content = do_shortcode( $content );
	$ret  = '';
	$ret .= '<div id="addrcolumn"'.$styledata.'>';
	$ret .= $content;
	$ret .= '</div>';
	return $ret;
}

add_shortcode( 'map_location', 'sc_map_location' );


function sc_map_frame( $atts, $content = null ) {
	extract(shortcode_atts(array(
			'style'	=>	'',
			'src'	=>	'',
			'width'	=>	'320',
	), $atts));

	$styledata = '';
	if ( $style != '' ) {
		$styledata = ' style="'.$style.'"';
	}

	$content = do_shortcode( $content );
	$ret  = '';
	$ret .= '<div id="mapcolumn"'.$styledata.'>';
	$ret .= '<div id="mapiframe">';
	$ret .= $content;
	$content = do_shortcode( '[map_iframe src="'.$src.'" width="'.$width.'"]' );
	$ret .= $content;
	$ret .= '</div>';
	$ret .= '</div>';
	return $ret;
}

add_shortcode( 'map_frame', 'sc_map_frame' );


function sc_map_iframe( $atts ) {
	extract(shortcode_atts(array(
			'src'	=>	'',
			'width'	=>	'320',
	), $atts));

	$ret  = '';
	$ret .= '<iframe name="mapiframe1" src="'.$src.'" width="'.$width.'"></iframe>';
	return $ret;
}

add_shortcode( 'map_iframe', 'sc_map_iframe' );


function sc_map_link( $atts ) {
	extract(shortcode_atts(array(
			'title' => '住所',
			'small' => 'true',
			'ellipsis' => 'true',
			'href' => '',
			'name' => 'globe',
			'desc' => '大きな地図で見る',
	), $atts));

	$content = do_shortcode( '[iconfont name="'.$name.'"]' );
	$ret  = '';
	if ( $title != '' ) {
		$ret .= '<span id="maptitle">'.$title.'</span>';
	}
	if ( $ellipsis == 'true' ) {
		$ret .= '　<sub>'.do_shortcode( '[iconfont name="ellipsis-h"]' ).'</sub>';
	}
	if ( $small == 'true' ) {
		$ret .= '<small>';
	}
	$ret .= '<a class="largermap ext-link ext-icon-2" href="'.$href.'" rel="external nofollow" target="_blank">';
	$ret .= $content;
	$ret .= $desc;
	$ret .= '</a>';
	if ( $small == 'true' ) {
		$ret .= '</small>';
	}
	return $ret;
}

add_shortcode( 'map_link', 'sc_map_link' );
?>