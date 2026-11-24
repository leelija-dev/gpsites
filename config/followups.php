<?php

/*
|--------------------------------------------------------------------------
| Automatic follow-ups
|--------------------------------------------------------------------------
|
| When a site owner has not replied to an offer, order or outreach mail,
| GPSites sends a short follow-up in the same email thread.
|
| Follow-ups stop as soon as the site owner (or the customer) replies, when
| the customer presses "Stop follow-ups", when the plan has expired, or after
| the last step below.
|
*/

return [

    // Master switch. GPSITES_FOLLOWUPS_ENABLED=false turns sending off everywhere.
    'enabled' => (bool) env('GPSITES_FOLLOWUPS_ENABLED', true),

    // Days to wait before each follow-up, counted from the previous mail in the thread.
    // "3,5" = first follow-up 3 days after the original, second 5 days after that (day 8).
    'days' => array_values(array_filter(array_map('intval', explode(',', (string) env('GPSITES_FOLLOWUP_DAYS', '3,5'))))),

    // Which conversations get follow-ups (user_mail_history.mail_type).
    'types' => ['offer', 'order', 'campaign'],

    // Never follow up on a conversation older than this.
    'max_age_days' => (int) env('GPSITES_FOLLOWUP_MAX_AGE', 30),

    // Safety limit per scheduler run.
    'per_run' => (int) env('GPSITES_FOLLOWUP_PER_RUN', 200),
];
