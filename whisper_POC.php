<?php

/*
$targetChannels = [];   //TODO: auslagern in function, in verbindung mit einer config-page
$user_override =        //TODO: aus (zukünftiger) config-datei auslesen, falls erwünscht
*/
function testHook($post_id)
{

    /*
     * to debug this function, echo values out and ignore the error message about invalid json in wordpress-frontend
     * check out the request in the networking tab of your browser. the "answere" will hold your echos
     */
    $webhook = 'https://discord.com/api/webhooks/828435049027469362/3Sp0PAVgeDPkgBlizoqD-KRiekrQ8WPQ86bJX8t1uvqEliuBDDZ6yBGAnoKYyKMJituH';

    $template = file_get_contents(__DIR__ . "/template/template.lax");

    $content = get_the_content(null, null, $post_id);
    $content = apply_filters('the_content', $content);   //cut wordpress markup from content

    //check whether we have images in markup; this is edgecase
    $image_replacer = "";
    $has_image = strpos($content, "<!-- wp:image");
    if ($has_image !== false && $has_image <= 300) {
        $image_replacer = "replaceThis";
    }

    //get only a snippet of the content to keep matters simple
    $content = substr($content, 0, 150) . ' ...';

    //get post details
    $title = get_the_title($post_id);
    $current_user = wp_get_current_user()->user_login;
    $link = get_permalink($post_id);

    //replace substitutions in template
    //   $template = str_replace("%TITLE%", $title, $template);
    //  $template = str_replace("%USER%", $current_user, $template);
    //  $template = str_replace("%THUMBNAIL%", $image_replacer, $template);
    //  $template = str_replace("%CONTENT%", $content, $template);
    //  $template = str_replace("%LINK%", $link, $template);

    //$body = wp_json_encode( $template );
    $response = wp_remote_post($webhook,
        [
            'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
            'body' => json_encode(
                [
                    "username" => "whisper",
                    "avatar_url" => "https://www.tiere-kleinanzeigen.com/export/7a59ecfa0f1fbf1e53c5bfb8e3baa.jpg",
                    "content" => "```ini
[This is the only content we have!]
Pls consider reading this text which is **really** cool!
```
http://clockwork.ddnss.org/wp-content/uploads/2021/03/rusty.gif
"
                ]),
            'method' => 'POST',
            'data_format' => 'body',
        ]
    );
    //debug
    //echo $template;
    //echo $response
}

//add_action( 'save_post', 'testHook' );    //triggers too often!
add_action('publish_post', 'testHook');

?>


?>