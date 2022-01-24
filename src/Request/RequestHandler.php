<?php

namespace Whisper\Request;

use Whisper\RequestHandlerInterface;

class RequestHandler implements RequestHandlerInterface
{
    public function sendMessage(string $messageBody):void
    {
        //TODO: abfragen, ob username überschrieben wurde, falls nicht auf "default" setzen
        if(!get_option('whisper_options'))
        {
            exit("no configuration found!");
        }
        else
        {
            $apiEndpoint = get_option('whisper_options');
        }

        //returns Object of WP_Error on failure, array on success
        $status = wp_remote_post( $apiEndpoint['discord_webhook'],
            [
                'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
                'body'=>wp_json_encode(
                    [
                        "content" => $messageBody
                    ] ),
                'method' => 'POST',
                'data_format' => 'body',
            ]);

        if(is_wp_error($status))
        {
            throw new \Exception("Fehler beim Senden des Requests");
        }
    }
}