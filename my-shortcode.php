<?php
/**
 * Additional Shortcodes
 */
//******************************************************************************
// Google Charts
//******************************************************************************
function sc_gchart($atts) {
	extract(shortcode_atts(array(
			'id' => 'gchart_div',
			'style' => '',
	), $atts));
	return '<div id="'.$id.'" style="'.$style.'"></div>';
}
add_shortcode('gchart', 'sc_gchart');


//******************************************************************************
// Timeliner
//******************************************************************************
function sc_timeline($atts, $content = null) {
	extract(shortcode_atts(array(
			'style' => '',
	), $atts));
	return '
		<div id="timelineContainer" style="'.$style.'">
			<div class="timelineToggle">
				<small><a class="expandAll expandAllclosed">すべて展開する</a></small>
			</div>
			<br class="clear" />'.do_shortcode($content).'<br class="clear" />
		</div>
	';
}
add_shortcode('timeline', 'sc_timeline');

function sc_timelineGroup($atts, $content = null) {
	extract(shortcode_atts(array(
			'title' => '',
			'tag' => 'h2',
	), $atts));
	return '
		<div class="timelineMajor">
			<'.$tag.' class="timelineMajorMarker"><span><a>'.$title.'</a></span></'.$tag.'>
			'.do_shortcode($content).'
		</div>
	';
}
add_shortcode('timelineGroup', 'sc_timelineGroup');

function sc_timelineEvent($atts, $content = null) {
	extract(shortcode_atts(array(
			'id' => '',
			'title' => '',
			'event' => '',
			'tag' => '',
	), $atts));
	if ($tag == '') {
		$eventTag = '';
	} else {
		$eventTag = '<'.$tag.'>'.$event.'</'.$tag.'>';
	}
	return '
		<dl class="timelineMinor">
			<dt id="'.$id.'"><a>'.$title.'</a><small id="'.$id.'DT" class="timelineEventDT">'.$event.'</small></dt>
			<dd id="'.$id.'EX" class="timelineEvent" style="display: none;">'.$eventTag.do_shortcode($content).'</dd>
		</dl>
	';
	
	unset($eventTag);
}
add_shortcode('timelineEvent', 'sc_timelineEvent');

function sc_timelineEventSingle($atts, $content = null) {
	extract(shortcode_atts(array(
			'event' => '',
			'tag' => 'h3',
			'desc' => '',
	), $atts));
	if ($tag == '') {
		$eventTag = '';
	} else {
		$eventTag = '<'.$tag.'>'.$event.'</'.$tag.'>';
	}
	if ($desc == '') {
		$descTag = '';
	} else {
		$descTag = '<p class="desc">'.$desc.'</p>';
	}
	return '
		<dl class="timelineMinor">
			<dd>'.$eventTag.do_shortcode($content).$descTag.'</dd>
		</dl>
	';
	
	unset($eventTag);
	unset($descTag);
}
add_shortcode('timelineEventSingle', 'sc_timelineEventSingle');

function sc_timelineMedia($atts, $content = null) {
	extract(shortcode_atts(array(
			'style' => '',
	), $atts));
	return '<div class="media" style="'.$style.'">'.do_shortcode($content).'</div>';
}
add_shortcode('timelineMedia', 'sc_timelineMedia');

function sc_timelineGallery($atts) {
	extract(shortcode_atts(array(
			'url' => '',
			'title' => '',
			'cred' => '',
			'desc' => '',
			'rel' => 'shadowbox[album]',
	), $atts));
	if ($url == '') {
		return '';
	} else {
		if ($cred == '') {
			$credTag = '';
		} else {
			$credTag = '<p class="cred"><small>'.$cred.'</small></p>';
		}
		if ($desc == '') {
			$descTag = '';
		} else {
			$descTag = '<p class="desc">'.$desc.'</p>';
		}
		return '
			<div class="gallery default">
				<div class="gallery-item">
					<a href="'.$url.'" rel="'.$rel.'">
						<img title="'.$title.'" src="'.$url.'" alt="" />
					</a>
				</div>
			</div>'.$credTag.$descTag
		;
	}
	unset($credTag);
	unset($descTag);
}
add_shortcode('timelineGallery', 'sc_timelineGallery');

function sc_timelineEmbed($atts, $content = null) {
	extract(shortcode_atts(array(
			'cred' => '',
			'desc' => '',
	), $atts));
	if ($cred == '') {
		$credTag = '';
	} else {
		$credTag = '<p class="cred"><small>'.$cred.'</small></p>';
	}
	if ($desc == '') {
		$descTag = '';
	} else {
		$descTag = '<p class="desc">'.$desc.'</p>';
	}
	return '<div>'.do_shortcode($content).'</div>'.$credTag.$descTag;

	unset($credTag);
	unset($descTag);
}
add_shortcode('timelineEmbed', 'sc_timelineEmbed');

function sc_timelineInfoList($atts) {
	extract(shortcode_atts(array(
			'list' => '',
			'delim' => '::::',
	), $atts));
	if ($list == '') {
		$liTag = '';
	} else {
		$liTag = '';
		$array = explode($delim, $list);
		$count = count($array);
		for ($i = 0; $i < $count; $i++) {
			$liTag = $liTag.'<li>'.$array[$i].'</li>';
		}
	}
	return '<ul class="moreInfo">'.$liTag.'</ul>';
	
	unset($liTag);
	unset($i);
	unset($array);
}
add_shortcode('timelineInfoList', 'sc_timelineInfoList');


//******************************************************************************
// Google Maps Column
//******************************************************************************
function sc_mapColumn($atts, $content = null) {
	extract(shortcode_atts(array(
			'style' => '',
	), $atts));
	return '<div id="mapcontainer" style="'.$style.'">'.do_shortcode($content).'</div>';
}
add_shortcode('mapColumn', 'sc_mapColumn');

function sc_mapLocation($atts, $content = null) {
	extract(shortcode_atts(array(
			'style' => '',
	), $atts));
	return '<div id="addrcolumn" style="'.$style.'">'.do_shortcode($content).'</div>';
}
add_shortcode('mapLocation', 'sc_mapLocation');

function sc_mapFrame($atts, $content = null) {
	extract(shortcode_atts(array(
			'style' => '',
			'src' => '',
			'width' => '320',
	), $atts));
	return '<div id="mapcolumn" style="'.$style.'"><div id="mapiframe">'.do_shortcode($content).'<iframe name="mapiframe1" src="'.$src.'" width="'.$width.'"></iframe></div></div>';
}
add_shortcode('mapFrame', 'sc_mapFrame');

function sc_mapFrameLink($atts) {
	extract(shortcode_atts(array(
			'title' => '住所',
			'href' => '',
			'name' => 'map-marker',
			'desc' => '大きな地図で見る',
	), $atts));
	return '<span id="maptitle">'.$title.'</span>　<sub><i class="icon-fixed-width icon-ellipsis-horizontal"></i></sub><small><a class="largermap ext-link ext-icon-2" href="'.$href.'" rel="external nofollow" target="_blank"><i class="icon-fixed-width icon-'.$name.'"></i>'.$desc.'</a></small>';
}
add_shortcode('mapFrameLink', 'sc_mapFrameLink');
?>