<?php

namespace Whisper\Settings;

use Whisper\Template\SettingsTemplateProvider;

class SettingsProvider
{
    private array $options;
    private SettingsTemplateProvider $templateProvider;

    public function __construct(SettingsTemplateProvider $templateProvider)
    {
        $this->templateProvider = $templateProvider;

        add_action('admin_menu', [$this, 'add_plugin_page']);
        add_action('admin_init', [$this, 'page_init']);

        // will return false at first run ( data not yet saved )
        if (!get_option('whisper_options')) {
            $this->options['hook_counter'] = 1;
            $this->options['discord_webhook0'] = "set discord webhook!";
            $this->options['name_override'] = "";
        } else {
            $this->options = get_option('whisper_options');

            //these lines will make sure the application won't run out of bounds
            if($this->options['hook_counter'] > 10) {
                $this->options['hook_counter'] = 10;
            }

            if($this->options['hook_counter'] < 1) {
                $this->options['hook_counter'] = 1;
            }
        }
    }

    public function add_plugin_page(): void
    {
        // This page will be under "Settings"
        add_options_page(
            'whisper_options',                                          //page title
            'Whisper Configuration',                                    //menu title
            'manage_options',                                           //"capability" -> user rights
            'whisper_options',                                          //menu -"slug" -> subdomain
            [$this, 'pageBuilderCallback']                              //callback
        );
    }

    public function pageBuilderCallback(): void
    {
        echo $this->templateProvider->getOptionsPageTemplateHead();

        settings_fields('whisper_option_group');                        // param option group
        do_settings_sections('whisper_options');                        // param page
        submit_button('Submit');

        echo $this->templateProvider->getOptionsPageTemplateTail();
    }

    public function page_init(): void
    {
        register_setting(
            'whisper_option_group',                                     // Option group
            'whisper_options',                                          // Option name
            [$this, 'sanitize']                                         // array which should be registered
        );

        add_settings_section(
            'whisper_section',                                          // ID
            'Whisper Configuration Page',                               // Title
            [$this, 'print_section_info'],                              // Callback
            'whisper_options'                                           // Page
        );

        add_settings_field(
            'hook_counter',                                             // ID
            'Number of Webhooks',                                       // Title
            [$this, 'hook_counter_callback'],                           // Callback
            'whisper_options',                                          // Page
            'whisper_section',                                          // Section
            ['insert' => 'hook_counter']                                // callback arguments
        );

        for($i = 0; $i < $this->options['hook_counter']; $i++)
        {
            add_settings_field(
                'discord_webhook'.$i,                                   // ID
                'Discord Webhook URI',                                  // Title
                [$this, 'discord_webhook_callback'],                    // Callback
                'whisper_options',                                      // Page
                'whisper_section',                                      // Section
                ['insert' => 'discord_webhook'.$i]                      // callback arguments
            );
        }

        add_settings_field(
            'name_override',                                            // ID
            'Display as',                                               // Title
            [$this, 'name_override_callback'],                          // Callback
            'whisper_options',                                          // Page
            'whisper_section',                                          // Section
            ['insert' => 'name_override']                               // callback arguments
        );
    }

    public function sanitize($input): array
    {
        $new_input = array();

        if (isset($input['hook_counter']))
            $new_input['hook_counter'] = sanitize_text_field($input['hook_counter']);

        for ($i = 0; $i < $this->options['hook_counter']; $i++) {
            if (isset($input['discord_webhook' .$i]))
                $new_input['discord_webhook'.$i] = sanitize_text_field($input['discord_webhook'.$i]);
        }

        if (isset($input['name_override']))
            $new_input['name_override'] = sanitize_text_field($input['name_override']);

        return $new_input;
    }

    public function print_section_info(array $args):void
    {
        echo $this->templateProvider->getOptionsPageTemplateDescription();
    }

    public function hook_counter_callback(array $args):void
    {
        printf(
            $this->templateProvider->getOptionsPageTemplateInput(), $args['insert'], $args['insert'],
            isset($this->options['hook_counter']) ? esc_attr($this->options['hook_counter']) : ''
        );
    }

    public function discord_webhook_callback(array $args):void
    {
        printf(
            $this->templateProvider->getOptionsPageTemplateInput(), $args['insert'], $args['insert'],
            isset($this->options[$args['insert']]) ? esc_attr($this->options[$args['insert']]) : ''
        );
    }

    public function name_override_callback(array $args):void
    {
        printf(
            $this->templateProvider->getOptionsPageTemplateInput(), $args['insert'], $args['insert'],
            isset($this->options['name_override']) ? esc_attr($this->options['name_override']) : ''
        );
    }

}