<?php

namespace NovaTheme\Providers;

use Plenty\Plugin\Templates\Twig;

/**
 * Data provider for the "Ceres::Template.Style" layout container, which is
 * rendered inside the document <head>. Loads the compiled NovaTheme
 * stylesheet once per page.
 */
class StyleProvider
{
    public function call(Twig $twig): string
    {
        return $twig->render('NovaTheme::assets.StyleTag');
    }
}
