<?php
/**
 * Whisper
 *
 * @package           PluginPackage
 * @author            clockw0rk
 * @copyright         clockw0rk
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Whisper
 * Plugin URI:        http://clockwork.ddnss.org/
 * Description:       A discord whisper spell
 * Version:           DuskyLory-DC-01
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            clockw0rk
 * Author URI:        http://clockwork.ddnss.org/
 * Text Domain:       plugin-slug
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

use Whisper\Content\ContentRepository;
use Whisper\Request\RequestHandler;
use Whisper\Settings\SettingsProvider;
use Whisper\Template\SettingsTemplateProvider;
use Whisper\Template\TemplateProvider;
use Whisper\WhisperMain;

require __DIR__ . '/vendor/autoload.php';

new SettingsProvider(new SettingsTemplateProvider(
                                            __DIR__ . "/data/optionsPageHead.html",
                                            __DIR__ . "/data/optionsPageTail.html",
                                            __DIR__ . "/data/optionsPageInput.html",
                                            __DIR__ . "/data/optionsPageDescription.html",
));

new WhisperMain(
    new ContentRepository(),
    new TemplateProvider(__DIR__. "/data/template.html"),
    new RequestHandler()
);

?>
