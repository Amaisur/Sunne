<?php

namespace NovaTheme\Providers;

use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;

/**
 * Boots the NovaTheme plugin.
 *
 * All page content is wired up declaratively through the "dataProviders" /
 * "defaultLayoutContainer" entries in plugin.json (see Ceres::Header,
 * Ceres::Homepage, Ceres::Footer, Ceres::Template.Style and
 * Ceres::Script.AfterScriptsLoaded). Nothing needs to be registered manually
 * here - this class only exists because plentymarkets requires every plugin
 * to declare a serviceProvider class.
 */
class NovaThemeServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot(Twig $twig, Dispatcher $dispatcher)
    {
    }
}
