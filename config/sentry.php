<?php

return array(
    'dsn' => env('SENTRY_LARAVEL_DSN', "https://b80485013b134c228e7a86e0d184b051@sentry.io/1298576"),

    // capture release as git sha
    // 'release' => trim(exec('git log --pretty="%h" -n1 HEAD')),

    // Capture bindings on SQL queries
    'breadcrumbs.sql_bindings' => true,

    // Capture default user context
    'user_context' => false,
);
