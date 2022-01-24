<?php

namespace Whisper;

interface RequestHandlerInterface
{
    public function sendMessage(string $messageBody): void;
}