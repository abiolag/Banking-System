<?php

'web' => [
    // ... existing middleware
    \App\Http\Middleware\TrackUserActivity::class,
    \App\Http\Middleware\CheckUserActivity::class,
],