<?php

namespace Whisper\Content;

use Whisper\ContentRepositoryInterface;

class ContentRepository implements ContentRepositoryInterface
{
    public function loadContent(int $postId): Content
    {
        $postContent = get_the_content( null, null, $postId );
        $postContent = wp_strip_all_tags( $postContent, false);
        $postImage   = $this->getImage($postId);
        $tags = wp_get_post_tags($postId);

        $tagString = "";
        foreach ($tags as $tag)
        {
            $tagString .= $tag->name . ", ";
        }
        $tagString = substr($tagString, 0, strlen($tagString)-2);

        if(!get_option('whisper_options'))
        {
            exit("no configuration found!");
        }
        else
        {
            $options = get_option('whisper_options');
        }

        //strip empty lines
        $postContent = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $postContent);

        return new Content(
            $postContent,
            get_the_title($postId),
            $options['name_override'] === "" ? wp_get_current_user()->user_login : $options['name_override'],
            $postImage,
            $tagString,
            get_permalink($postId),
            get_bloginfo('name'),
        );
    }

    private function getImage(int $postId): string
    {
        $images = get_attached_media('image', $postId);
        foreach ($images as $image) {
            return $image->guid;
        }
        return "";
    }
}