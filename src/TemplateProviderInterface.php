<?php
namespace Whisper;

use Whisper\Content\Content;

interface TemplateProviderInterface
{
    public function getRequestBody(Content $content):string;
}