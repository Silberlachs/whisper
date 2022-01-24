<?php

namespace Whisper\Template;

class SettingsTemplateProvider
{
    private string $templateFileHead;
    private string $templateFileTail;
    private string $templateFileInput;
    private string $templateFileDescription;

    public function __construct(
        string $templateFileHead,
        string $templateFileTail,
        string $templateFileInput,
        string $templateFileDescription
    )
    {
        $this->templateFileHead             = file_get_contents($templateFileHead);
        $this->templateFileTail             = file_get_contents($templateFileTail);
        $this->templateFileInput            = file_get_contents($templateFileInput);
        $this->templateFileDescription      = file_get_contents($templateFileDescription);
    }

    public function getOptionsPageTemplateHead(): string
    {
        return $this->templateFileHead;
    }

    public function getOptionsPageTemplateTail():string
    {
        return $this->templateFileTail;
    }

    public function getOptionsPageTemplateInput():string
    {
        return $this->templateFileInput;
    }

    public function getOptionsPageTemplateDescription():string
    {
        return $this->templateFileDescription;
    }
}