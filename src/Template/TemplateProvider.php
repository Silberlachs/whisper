<?php

namespace Whisper\Template;

use Whisper\Content\Content;
use Whisper\TemplateProviderInterface;

class TemplateProvider implements TemplateProviderInterface
{
    private string $template;

    public function __construct(string $templateFile)
    {
        $this->template = file_get_contents($templateFile);
    }

    public function getRequestBody(Content $content): string
    {
        $thumbNail = $content->getThumbnail();

        if($thumbNail !== "")
        {
            $thumbNail = '<img src="'.$thumbNail.'">';
        }

        $template = str_replace("%TITLE%"     , $content->getTitle()       , $this->template);
        $template = str_replace("%USER%"      , $content->getUser()        , $template);
        $template = str_replace("%THUMBNAIL%" , $thumbNail                 , $template);
        $template = str_replace("%CONTENT%"   , $content->getContent()     , $template);
        $template = str_replace("%LINK%"      , $content->getPermalink()   , $template);
        $template = str_replace("%TAGS%"      , $content->getTags()        , $template);
        $template = str_replace("(more&hellip;)", ""                , $template);

        return $template;
    }
}