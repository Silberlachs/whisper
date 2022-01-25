<?php

namespace Whisper\Request;

use Whisper\RequestHandlerInterface;

class RequestHandler implements RequestHandlerInterface
{
    public function sendMessage(string $messageBody):void
    {
        if(!get_option('whisper_options'))
        {
            exit("no configuration found!");
        }
        else
        {
            $pluginConfig = get_option('whisper_options');
            if(!array_key_exists('name_override',$pluginConfig) && $pluginConfig['name_override'] !== "")
            {
                $pluginConfig['name_override'] = wp_get_current_user();
            }
        }

        for($c = 0;$c<$pluginConfig['hook_counter']; $c++)
        {

            $postContent = wp_remote_post( $pluginConfig['discord_webhook' . $c],
                [
                    'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
                    'body'=>wp_json_encode(
                        [
                            "content" => $messageBody,
                        ] ),
                    'method' => 'POST',
                    'data_format' => 'body',
                ]);

            if(is_wp_error($postContent))
            {
                throw new \Exception($postContent);
            }
        }
    }
}