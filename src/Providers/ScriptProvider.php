<?php

namespace NovaTheme\Providers;

use Plenty\Plugin\Templates\Twig;

/**
 * Data provider for the "Ceres::Script.AfterScriptsLoaded" layout container.
 * Loads the NovaTheme JavaScript entry module as type="module" (natively
 * deferred) after the Ceres/Vue bundle has been requested.
 */
class ScriptProvider
{
    public function call(Twig $twig): string
    {
        return $twig->render('NovaTheme::assets.ScriptTag');
    }
}
