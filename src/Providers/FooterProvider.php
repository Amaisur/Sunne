<?php

namespace NovaTheme\Providers;

use NovaTheme\Config\ContentConfig;
use Plenty\Plugin\Templates\Twig;

/**
 * Data provider for the "Ceres::Footer" layout container.
 * Ceres/PageDesign/Partials/Footer.twig falls back to this content instead
 * of its own default footer markup whenever the container is non-empty. The
 * "back to top" buttons stay outside this container and remain untouched.
 */
class FooterProvider
{
    public function call(Twig $twig): string
    {
        return $twig->render('NovaTheme::partials.Footer', [
            'footer' => ContentConfig::footer(),
        ]);
    }
}
