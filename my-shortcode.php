<?php
/**
 * Additional Shortcodes
 */
//******************************************************************************
// Google Charts
//******************************************************************************
function sc_gchart( $atts ) {
	extract( shortcode_atts( array(
			'id' => 'gchart_div',
			'style' => '',
	), $atts ) );
	$styledata = '';
	if ( $style != '' ) {
		$styledata = ' style="'.$style.'"';
	}
	return '<div id="'.$id.'"'.$styledata.'></div>';
}
add_shortcode( 'gchart', 'sc_gchart' );


//******************************************************************************
// Timeliner
//******************************************************************************
function sc_timeline( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'style' => '',
	), $atts ) );
	$styledata = '';
	if ( $style != '' ) {
		$styledata = ' style="'.$style.'"';
	}
	$ret  = '';
	$ret .= '<div id="timelineContainer"'.$styledata.'>';
	$ret .= '<div class="timelineToggle">';
	$ret .= '<small><a class="expandAll expandAllclosed"></a></small>';
	$ret .= '</div>';
	$ret .= '<br class="clear" />'.do_shortcode( $content ).'<br class="clear" />';
	$ret .= '</div>';
	return $ret;
}
add_shortcode( 'timeline', 'sc_timeline' );


function sc_timelineGroup( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'title' => '',
			'tag' => 'h2',
	), $atts ) );
	$ret  = '';
	$ret .= '<div class="timelineMajor">';
	$ret .= '<'.$tag.' class="timelineMajorMarker"><span><a>'.$title.'</a></span></'.$tag.'>';
	$ret .= do_shortcode( $content );
	$ret .= '</div>';
	return $ret;
}
add_shortcode( 'timelineGroup', 'sc_timelineGroup' );


function sc_timelineEvent( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'id' => '',
			'title' => '',
			'event' => '',
			'tag' => '',
	), $atts ) );
	$eventTag = '';
	if ( $tag != '' ) {
		$eventTag = '<'.$tag.'>'.$event.'</'.$tag.'>';
	}
	$ret  = '';
	$ret .= '<dl class="timelineMinor">';
	$ret .= '<dt id="'.$id.'">';
	$ret .= '<a>'.$title.'</a>';
	$ret .= '<small id="'.$id.'DT" class="timelineEventDT">'.$event.'</small>';
	$ret .= '</dt>';
	$ret .= '<dd id="'.$id.'EX" class="timelineEvent" style="display: none;">';
	$ret .= $eventTag;
	$ret .= do_shortcode( $content );
	$ret .= '</dd>';
	$ret .= '</dl>';
	return $ret;
}
add_shortcode( 'timelineEvent', 'sc_timelineEvent' );


function sc_timelineEventSingle( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'event' => '',
			'tag' => 'h3',
			'desc' => '',
	), $atts ) );
	$eventTag = '';
	if ( $tag != '' ) {
		$eventTag = '<'.$tag.'>'.$event.'</'.$tag.'>';
	}
	$descTag = '';
	if ( $desc != '' ) {
		$descTag = '<p class="desc">'.$desc.'</p>';
	}
	$ret  = '';
	$ret .= '<dl class="timelineMinor">';
	$ret .= '<dd>';
	$ret .= $eventTag;
	$ret .= do_shortcode( $content );
	$ret .= $descTag;
	$ret .= '</dd>';
	$ret .= '</dl>';
	return $ret;
}
add_shortcode( 'timelineEventSingle', 'sc_timelineEventSingle' );


function sc_timelineMedia( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'style' => '',
	), $atts ) );
	$styledata = '';
	if ( $style != '' ) {
		$styledata = ' style="'.$style.'"';
	}
	$ret  = '';
	$ret .= '<div class="media"'.$styledata.'>';
	$ret .= do_shortcode( $content );
	$ret .= '</div>';
	return $ret;
}
add_shortcode( 'timelineMedia', 'sc_timelineMedia' );


function sc_timelineGallery( $atts ) {
	extract( shortcode_atts( array(
			'url' => '',
			'title' => '',
			'cred' => '',
			'desc' => '',
			'rel' => 'shadowbox[album]',
	), $atts ) );
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
add_shortcode( 'timelineGallery', 'sc_timelineGallery' );


function sc_timelineEmbed( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'cred' => '',
			'desc' => '',
	), $atts ) );
	$credTag = '';
	if ( $cred != '' ) {
		$credTag = '<p class="cred"><small>'.$cred.'</small></p>';
	}
	$descTag = '';
	if ( $desc != '' ) {
		$descTag = '<p class="desc">'.$desc.'</p>';
	}
	$ret  = '';
	$ret .= '<div>';
	$ret .= do_shortcode( $content );
	$ret .= '</div>';
	$ret .= $credTag;
	$ret .= $descTag;
	return $ret;
}
add_shortcode( 'timelineEmbed', 'sc_timelineEmbed' );


function sc_timelineInfoList( $atts ) {
	extract( shortcode_atts( array(
			'list' => '',
			'delim' => '::::',
	), $atts ) );
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
add_shortcode( 'timelineInfoList', 'sc_timelineInfoList' );


//******************************************************************************
// Google Maps Column
//******************************************************************************
function sc_mapColumn( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'style' => '',
	), $atts ) );
	$styledata = '';
	if ( $style != '' ) {
		$styledata = ' style="'.$style.'"';
	}
	$ret  = '';
	$ret .= '<div id="mapcontainer"'.$styledata.'>';
	$ret .= do_shortcode( $content );
	$ret .= '</div>';
	return $ret;
}
add_shortcode( 'mapColumn', 'sc_mapColumn' );


function sc_mapLocation( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'style' => '',
	), $atts ) );
	$styledata = '';
	if ( $style != '' ) {
		$styledata = ' style="'.$style.'"';
	}
	$ret  = '';
	$ret .= '<div id="addrcolumn"'.$styledata.'>';
	$ret .= do_shortcode( $content );
	$ret .= '</div>';
	return $ret;
}
add_shortcode( 'mapLocation', 'sc_mapLocation' );


function sc_mapFrame( $atts, $content = null ) {
	extract( shortcode_atts( array(
			'style' => '',
			'src' => '',
			'width' => '320',
	), $atts ) );
	$styledata = '';
	if ( $style != '' ) {
		$styledata = ' style="'.$style.'"';
	}
	$ret  = '';
	$ret .= '<div id="mapcolumn"'.$styledata.'>';
	$ret .= '<div id="mapiframe">';
	$ret .= do_shortcode( $content );
	$ret .= '<iframe name="mapiframe1" src="'.$src.'" width="'.$width.'"></iframe>';
	$ret .= '</div>';
	$ret .= '</div>';
	return $ret;
}
add_shortcode( 'mapFrame', 'sc_mapFrame' );


function sc_mapFrameLink( $atts ) {
	extract( shortcode_atts( array(
			'title' => '住所',
			'href' => '',
			'name' => 'map-marker',
			'desc' => '大きな地図で見る',
	), $atts ) );
	$ret  = '';
	$ret .= '<span id="maptitle">'.$title.'</span>';
	$ret .= '　<sub>'.do_shortcode( '[iconfont name="ellipsis-horizontal"]' ).'</sub>';
	$ret .= '<small>';
	$ret .= '<a class="largermap ext-link ext-icon-2" href="'.$href.'" rel="external nofollow" target="_blank">';
	$ret .= do_shortcode( '[iconfont name="'.$name.'"]' );
	$ret .= $desc;
	$ret .= '</a>';
	$ret .= '</small>';
	return $ret;
}
add_shortcode( 'mapFrameLink', 'sc_mapFrameLink' );
?>