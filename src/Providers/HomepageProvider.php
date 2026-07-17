<?php

namespace NovaTheme\Providers;

use NovaTheme\Config\ContentConfig;
use Plenty\Plugin\Templates\Twig;

/**
 * Data provider for the "Ceres::Homepage" layout container.
 * Ceres/Homepage/Homepage.twig falls back to this content instead of
 * MarketingHomepage.twig whenever the container is non-empty.
 */
class HomepageProvider
{
    public function call(Twig $twig): string
    {
        return $twig->render('NovaTheme::Homepage', [
            'heroSlides' => ContentConfig::heroSlides(),
            'promoCards' => ContentConfig::promoCards(),
            'companyIntro' => ContentConfig::companyIntro(),
            'insights' => ContentConfig::insights(),
            'contact' => ContentConfig::contact(),
            'floatingActions' => ContentConfig::floatingActions(),
            'contactModalFields' => ContentConfig::contactModalFields(),
        ]);
    }
}
