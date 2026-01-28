<?php

use Illuminate\Support\Facades\Schedule;
use App\Jobs\GenerarEnviosCavaliDiariosJob;

Schedule::job(new GenerarEnviosCavaliDiariosJob)->everyMinute();
