<?php

namespace Whisper\Content;

class Content
{
    private string $content;
    private string $title;
    private string $user;
    private string $permalink;
    private string $thumbnail;
    private string $tags;

    public function __construct
    (
        string $content,
        string $title,
        string $user,
        string $thumbnail,
        string $tags,
        string $permalink
    )
    {
        $this->content = $this->getSnippet($content);
        $this->title = $title;
        $this->user = $user;
        $this->thumbnail = $thumbnail;
        $this->permalink = $permalink;
        $this->tags = $tags;
    }

    private function getSnippet(string $content):string
    {
        return substr($content,0,300) . ' ...';
    }

    public function getTags():string
    {
        return $this->tags;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    public function getPermalink(): string
    {
        return $this->permalink;
    }
}