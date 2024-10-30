<?php

namespace App\Filament\Resources\NResource\Widgets;

use Filament\Widgets\Widget;
use App\Jobs\FetchAndStoreCountries;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
class RunCountryJobWidget extends Widget
{
    protected static string $view = 'filament.resources.n-resource.widgets.run-country-job-widget';
    // عنوان ویجت
    protected static ?string $heading = 'اجرای دستور Job';

    public function runJob()
    {
        Artisan::call('queue:work', [
            '--stop-when-empty' => true,
        ]);
        FetchAndStoreCountries::dispatch();

        Notification::make()
            ->title('عملبات با موفقیت انجام شد')
            ->success()
            ->send();
    }
}
