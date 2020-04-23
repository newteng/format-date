<?php

namespace Newteng\FormatDate;


class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(FormatDateToStr::class, function () {
            return new FormatDateToStr();
        });

        $this->app->alias(FormatDateToStr::class, 'format_date_to_str');
    }

    public function provides()
    {
        return [FormatDateToStr::class, 'format_date_to_str'];
    }
}