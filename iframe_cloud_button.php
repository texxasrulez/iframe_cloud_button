<?php

/**
 * Roundcube Plugin iframe_cloud_button
 * Adds a taskbar button that opens a configured URL
 * inside an <iframe> in the existing Roundcube mainscreen area.
 */

class iframe_cloud_button extends rcube_plugin
{
    // Show the button in the main tasks
    public $task = 'mail|settings|addressbook|calendar|tasks';

    private $url;

    public function init()
    {
        $rcmail = rcmail::get_instance();

        // Load plugin config
        $this->load_config();

        // Get URL from config
        $this->url = $rcmail->config->get('iframe_cloud_button_url');

        // If no URL is configured, don't register anything
        if (empty($this->url)) {
            return;
        }

        // Load localization (labels['cloud'] etc.)
        $this->add_texts('localization/');

        // Expose URL to JS
        $rcmail->output->set_env('iframe_cloud_button_url', $this->url);

        // Include JS
        $this->include_script('iframe_cloud_button.js');

        // Include skin-specific CSS
        $skin = $rcmail->config->get('skin', 'larry');
        $skin_css = 'skins/' . $skin . '/iframe_cloud_button.css';

        if (file_exists($this->home . '/' . $skin_css)) {
            $this->include_stylesheet($skin_css);
        }
        else {
            // Fallback to larry CSS if skin-specific missing
            $fallback = 'skins/larry/iframe_cloud_button.css';
            if (file_exists($this->home . '/' . $fallback)) {
                $this->include_stylesheet($fallback);
            }
        }

        // Add the taskbar button
        $this->add_button(
            array(
                'command'     => 'plugin.iframe_cloud_button',
                'type'        => 'link',
                'label'       => 'iframe_cloud_button.cloud',
                'class'       => 'button-iframe-cloud',
                'classsel'    => 'button-iframe-cloud button-selected',
                'innerclass'  => 'button-inner',
            ),
            'taskbar'
        );
    }
}
