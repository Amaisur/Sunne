<?php

namespace NovaTheme\Providers;

use NovaTheme\Config\ContentConfig;
use Plenty\Plugin\Templates\Twig;

/**
 * Data provider for the "Ceres::Header" layout container.
 * Ceres/PageDesign/Partials/Header/Header.twig falls back to this content
 * instead of DefaultHeader.twig whenever the container is non-empty.
 */
class HeaderProvider
{
    public function call(Twig $twig): string
    {
        return $twig->render('NovaTheme::partials.Header', [
            'navigation' => ContentConfig::navigation(),
            'megaMenu' => ContentConfig::megaMenu(),
        ]);
    }
}
