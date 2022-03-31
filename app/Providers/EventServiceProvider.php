<?php

namespace App\Providers;

use App\Models\File_path;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ]

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            'Alexusmai\LaravelFileManager\Events\FilesUploaded',
            function ($event) {
                $path = $event->files();
//                dump($event->disk());
                foreach ($path as $key => $value) {
                    $file = new File_path();
                    $file->user_id = auth()->user()->id;
                    $file->path = $value["path"];
                    $file->save();
                }
            }
        );

        Event::listen(
            'Alexusmai\LaravelFileManager\Events\Deleting',
            function ($event) {
                $path = $event->items();
                foreach ($path as $key => $value) {
                   File_path::where('path', '=', $value["path"])->where('user_id', '=', auth()->user()->id)->delete();
                }

            }
        );
    }
}
