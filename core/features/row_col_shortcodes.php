<?php 

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}



function cod_social_icons( $atts, $content = "" ) {
    $atts = (array)$atts;
    array_walk($atts, 'esc_attr') ;
    $links = get_field('social_icons','options');
    $content = '';
    if (!empty($atts) && in_array('list', $atts)) {
        if (!empty($links)) {
            $content = '<ul class="inline social-icons-container ' . implode(' ', $atts   ) . '">' ;
            foreach ($links as $link) {
                $content .= '<li><a href="'.$link['link'].'"><i class="fa fa-'.$link['type'].'" target="_blank" aria-hidden="true">&nbsp;</i></a></li>';
            } // end foreach 
            $content .= '</ul>';
        } // end if 
    } else {
        if (!empty($links)) {
            $content = '<p class="social-icons-container">';
            foreach ($links as $link) {
                $content .= '<a href="'.$link['link'].'"><i class="fa fa-'.$link['type'].'" target="_blank" aria-hidden="true">&nbsp;</i></a>';
            }
            $content .='</p>';
        }
    } // end if 
    
        
    
    return $content;
}
add_shortcode( 'social_icons', 'cod_social_icons' );





/**
 * add columns shortcode
 */
function cod_columns_shortcode( $atts, $content = "" ) {
    $atts = (array)$atts;
    array_walk($atts, 'esc_attr') ;
    $content = trim($content);

    // remove first <br />
    if (substr($content, 0,6) == '<br />') {
        $content = substr($content, 6);
    }
    // remove last <br />
    if (substr($content, -6) == '<br />') {
        $content = substr($content,0, -6);
    }

    // data interchange. Add interchange=12 to add data-interchange for that image ID
    $interchange = false ;
    if (isset($atts['interchange'])) {
        if (function_exists('data_interchange') && function_exists('acf_get_attachment')) {
            $interchange = data_interchange(acf_get_attachment(get_post(get_post_thumbnail_id( $atts['interchange'] ))),false);
        } // end if 
        $atts[] = 'interchange interchange-for-'.$atts['interchange']; // add extra classes
        unset($atts['interchange']); // because it will be a number, so remove it
        
    } // end if 
    $other_classes = implode(' ', $atts   );
    if (strpos($other_classes, 'small') === FALSE) { // default to small-12
        $other_classes .= ' small-12';
    } // end if 
    
    // remove loose ending p tags
    $content = force_balance_tags($content);

    $content = '<div class="columns ' . $other_classes . '" '.$interchange.'>' . 
        do_shortcode( ( trim( $content ) )) 
        . '</div>';
    ;
    return $content;
}
add_shortcode( 'col', 'cod_columns_shortcode' );


/**
 * add row shortcode
 */
function cod_row_shortcode( $atts, $content = "" ) {
    $atts = (array)$atts;
    array_walk($atts, 'esc_attr') ;
    $content = trim($content);
    // remove first <br />
    if (substr($content, 0,6) == '<br />') {
        $content = substr($content, 6);
    }
    // remove last <br />
    if (substr($content, -6) == '<br />') {
        $content = substr($content,0, -6);
    }
    // data interchange. Add interchange=12 to add data-interchange for that image ID
    $interchange = false ;
    if (isset($atts['interchange'])) {
        if (function_exists('data_interchange') && function_exists('acf_get_attachment')) {
            $interchange = data_interchange(acf_get_attachment(get_post(get_post_thumbnail_id( $atts['interchange'] ))),false);
        } // end if 
        $atts[] = 'interchange interchange-for-'.$atts['interchange']; // add extra classes
        unset($atts['interchange']); // because it will be a number, so remove it
        
    } // end if 
    
    $other_classes = implode(' ', $atts   );
    
    // remove loose ending p tags
    $content = force_balance_tags($content);
    
    $content = '<div class="row ' . $other_classes . '">' . 
        do_shortcode( ( trim( $content ) )) 
        . '</div>';
    ;
    
    return $content;

}
add_shortcode( 'row', 'cod_row_shortcode' );


function content_shortcode( $atts ){
    return get_the_content();
}
add_shortcode( 'content', 'content_shortcode' );

function title_shortcode( $atts ){
    return get_the_title();
}
add_shortcode( 'title', 'title_shortcode' );


add_action('init','cod_custom_wpautop',90);

function cod_custom_wpautop() {
    remove_filter('the_content', 'wpautop');
    remove_filter('acf_the_content', 'wpautop');
    add_filter('the_content', 'cod_wpautop');
    add_filter('acf_the_content', 'cod_wpautop');
}


/**
 * Replaces double line-breaks with paragraph elements.
 *
 * A group of regex replaces used to identify text formatted with newlines and
 * replace double line-breaks with HTML paragraph tags. The remaining line-breaks
 * after conversion become <<br />> tags, unless $br is set to '0' or 'false'.
 *
 * @since 0.71
 *
 * @param string $pee The text which has to be formatted.
 * @param bool   $br  Optional. If set, this will convert all remaining line-breaks
 *                    after paragraphing. Default true.
 * @return string Text which has been converted into correct paragraph tags.
 */
function cod_wpautop( $pee, $br = true ) {
    $pre_tags = array();

    if ( trim($pee) === '' )
        return '';

    // Just to make things a little easier, pad the end.
    $pee = $pee . "\n";

    /*
     * Pre tags shouldn't be touched by autop.
     * Replace pre tags with placeholders and bring them back after autop.
     */
    if ( strpos($pee, '<pre') !== false ) {
        $pee_parts = explode( '</pre>', $pee );
        $last_pee = array_pop($pee_parts);
        $pee = '';
        $i = 0;

        foreach ( $pee_parts as $pee_part ) {
            $start = strpos($pee_part, '<pre');

            // Malformed html?
            if ( $start === false ) {
                $pee .= $pee_part;
                continue;
            }

            $name = "<pre wp-pre-tag-$i></pre>";
            $pre_tags[$name] = substr( $pee_part, $start ) . '</pre>';

            $pee .= substr( $pee_part, 0, $start ) . $name;
            $i++;
        }

        $pee .= $last_pee;
    }
    // Change multiple <br>s into two line breaks, which will turn into paragraphs.
    $pee = preg_replace('|<br\s*/?>\s*<br\s*/?>|', "\n\n", $pee);

    $allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';

    // Add a double line break above block-level opening tags.
    $pee = preg_replace('!(<' . $allblocks . '[\s/>])!', "\n\n$1", $pee);

    // Add a double line break below block-level closing tags.
    $pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);

    $shortcode_blocks = '(?:row|col)';
    $pee = preg_replace('!(\[' . $shortcode_blocks . '[\s/\]])!', "\n\n$1", $pee);
    $pee = preg_replace('!(\[/' . $shortcode_blocks . '\])!', "$1\n\n", $pee);

    // Standardize newline characters to "\n".
    $pee = str_replace(array("\r\n", "\r"), "\n", $pee);

    // Find newlines in all elements and add placeholders.
    $pee = wp_replace_in_html_tags( $pee, array( "\n" => " <!-- wpnl --> " ) );

    // Collapse line breaks before and after <option> elements so they don't get autop'd.
    if ( strpos( $pee, '<option' ) !== false ) {
        $pee = preg_replace( '|\s*<option|', '<option', $pee );
        $pee = preg_replace( '|</option>\s*|', '</option>', $pee );
    }

    /*
     * Collapse line breaks inside <object> elements, before <param> and <embed> elements
     * so they don't get autop'd.
     */
    if ( strpos( $pee, '</object>' ) !== false ) {
        $pee = preg_replace( '|(<object[^>]*>)\s*|', '$1', $pee );
        $pee = preg_replace( '|\s*</object>|', '</object>', $pee );
        $pee = preg_replace( '%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $pee );
    }

    /*
     * Collapse line breaks inside <audio> and <video> elements,
     * before and after <source> and <track> elements.
     */
    if ( strpos( $pee, '<source' ) !== false || strpos( $pee, '<track' ) !== false ) {
        $pee = preg_replace( '%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $pee );
        $pee = preg_replace( '%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $pee );
        $pee = preg_replace( '%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $pee );
    }

    // Remove more than two contiguous line breaks.
    $pee = preg_replace("/\n\n+/", "\n\n", $pee);

    // Split up the contents into an array of strings, separated by double line breaks.
    $pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);

    // Reset $pee prior to rebuilding.
    $pee = '';

    // Rebuild the content as a string, wrapping every bit with a <p>.
    foreach ( $pees as $tinkle ) {
        $pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
    }

    // Under certain strange conditions it could create a P of entirely whitespace.
    $pee = preg_replace('|<p>\s*</p>|', '', $pee);

    // Add a closing <p> inside <div>, <address>, or <form> tag if missing.
    $pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);

    // If an opening or closing block element tag is wrapped in a <p>, unwrap it.
    $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
    $pee = preg_replace('!<p>\s*(\[/?' . $shortcode_blocks . '[^\]]*\])\s*</p>!', "$1", $pee);

    // In some cases <li> may get wrapped in <p>, fix them.
    $pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee);

    // If a <blockquote> is wrapped with a <p>, move it inside the <blockquote>.
    $pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
    $pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);

    // If an opening or closing block element tag is preceded by an opening <p> tag, remove it.
    $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
    $pee = preg_replace('!<p>\s*(\[/?' . $allblocks . '[^\]]*\])!', "$1", $pee);

    // If an opening or closing block element tag is followed by a closing <p> tag, remove it.
    $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
    $pee = preg_replace('!(\[/?' . $allblocks . '[^\]]*\])\s*</p>!', "$1", $pee);

    // Optionally insert line breaks.
    if ( $br ) {
        // Replace newlines that shouldn't be touched with a placeholder.
        $pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', '_autop_newline_preservation_helper', $pee);

        // Normalize <br>
        $pee = str_replace( array( '<br>', '<br/>' ), '<br />', $pee );

        // Replace any new line characters that aren't preceded by a <br /> with a <br />.
        $pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee);

        // Replace newline placeholders with newlines.
        $pee = str_replace('<WPPreserveNewline />', "\n", $pee);
    }

    // If a <br /> tag is after an opening or closing block tag, remove it.
    $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
    $pee = preg_replace('!(\[/?' . $shortcode_blocks . '[^\]]*\])\s*<br />!', "$1", $pee);

    // If a <br /> tag is before a subset of opening or closing block tags, remove it.
    $pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
    $pee = preg_replace( "|\n</p>$|", '</p>', $pee );

    // Replace placeholder <pre> tags with their original content.
    if ( !empty($pre_tags) )
        $pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);

    // Restore newlines in all elements.
    if ( false !== strpos( $pee, '<!-- wpnl -->' ) ) {
        $pee = str_replace( array( ' <!-- wpnl --> ', '<!-- wpnl -->' ), "\n", $pee );
    }
    
    return $pee;
}