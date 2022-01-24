<?php
namespace Whisper;

use Whisper\Content\Content;

interface ContentRepositoryInterface
{
    public function loadContent(int $postId): Content;
}