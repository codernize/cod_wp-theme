<?php 
add_filter('wp_mail', 'cod_skin_wp_mail', 15, 1);
function cod_skin_wp_mail($atts)
{
    if (isset($atts['message'])) {
        $message = $atts['message'];
        if (strpos($message, '<p>') === false) {
            $message = apply_filters('the_content',$message);
        }
            
        $message = str_replace(
            [
                '<p>',
                '<a class="button" ',
                '<a ',
                '<h2>',
                '<blockquote',
            ],
            [
                '<p style="margin: 0; margin-top: 7px; margin-bottom: 20px; padding: 0; font-size: 13px; font-weight: normal; color: #535353; line-height: 22px; text-align: justify;">',
                '<a style="text-decoration: none;color: white;background-color: #d10100;padding: 6px 11px;" class="button" ',
                '<a style="text-decoration: none;color: #fd2323; " ',
                '<h2 style="margin: 0; padding: 0; font-size: 16px; font-weight: bold; color: #fd2323; text-align: left;">',
                '<blockquote style="font-family: Helvetica, arial, sans-serif; font-size: 14px; color: #4C4C4C; text-align: left; line-height: 24px;font-style: italic;border-left: 4px solid #C8C8C8;padding: 10px 20px;  margin-left: 0;" ',
            ],
            $message
        );
        ob_start();

        include_once 'mail-header.php';
        echo $message;
        include_once 'mail-footer.php';

        $message = ob_get_clean();
        $message = str_replace(
            ['%SUBJECT%'],
            [$atts['subject']],
            $message
        );
        $atts['message'] = $message;
    }

    return $atts;
}

add_filter('wp_mail_content_type', 'cod_set_html_content_type');
function cod_set_html_content_type()
{
    return 'text/html';
}
