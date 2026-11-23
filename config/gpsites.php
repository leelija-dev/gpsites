<?php

/*
|--------------------------------------------------------------------------
| GPSites public-site settings
|--------------------------------------------------------------------------
|
| Brand details used by the public website (footer, contact blocks,
| structured data and social share tags). Override any value in .env.
|
*/

return [

    'brand' => 'GPSites',

    // One-sentence definition used in meta, schema and the footer.
    'tagline' => 'GPSites is a link building marketplace and outreach automation tool for finding publishers, sending offers and managing orders.',

    // Public contact email. Set GPSITES_CONTACT_EMAIL=hello@gpsites.io once that inbox exists.
    'contact_email' => env('GPSITES_CONTACT_EMAIL', 'info@leelija.com'),

    'phones' => [
        '+91 629 010 1838',
        '+91 332 584 9017',
    ],

    'address' => [
        'street' => 'Taki Road, Bamunmura, Barasat',
        'locality' => 'Kolkata',
        'postal_code' => '700125',
        'region' => 'West Bengal',
        'country' => 'IN',
    ],

    'office_hours' => '10:00 AM - 6:30 PM',

    'parent_company' => 'Leelija',

    // Social profiles, shown in the footer and in the Organization "sameAs" schema.
    // Empty values are hidden. Any of these can still be overridden in .env.
    'social' => [
        'linkedin' => env('GPSITES_LINKEDIN_URL', 'https://www.linkedin.com/company/gpsites-io/'),
        'x' => env('GPSITES_X_URL', 'https://x.com/GpsitesIO'),
        'facebook' => env('GPSITES_FACEBOOK_URL', 'https://www.facebook.com/gpsites.io'),
        'instagram' => env('GPSITES_INSTAGRAM_URL', ''),
        'youtube' => env('GPSITES_YOUTUBE_URL', ''),
    ],

    // Google Tag Manager container (GA4 is configured inside GTM).
    // Not loaded when APP_ENV is local or testing. Set GTM_ID= (empty) to disable.
    'gtm_id' => env('GTM_ID', 'GTM-K3QH7SPK'),

    // Default image for social shares (1200x630 recommended).
    'og_image' => env('GPSITES_OG_IMAGE', '/images/og-default.png'),

];
