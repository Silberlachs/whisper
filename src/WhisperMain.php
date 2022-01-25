<?php

namespace Whisper;

class WhisperMain
{
    private ContentRepositoryInterface $contentRepository;
    private TemplateProviderInterface $templateProvider;
    private RequestHandlerInterface $requestHandler;

    public function __construct
    (
        ContentRepositoryInterface $contentRepository,
        TemplateProviderInterface $templateProvider,
        RequestHandlerInterface $requestHandler
    )
    {
        add_action( 'publish_post', [$this, 'sendTeamsRequest'] );
        $this->contentRepository = $contentRepository;
        $this->templateProvider = $templateProvider;
        $this->requestHandler = $requestHandler;
    }

    public function sendTeamsRequest($post_id)
    {
        $content = $this->contentRepository->loadContent($post_id);
        $template = $this->templateProvider->getRequestBody($content);
        $this->requestHandler->sendMessage($template);
    }
}