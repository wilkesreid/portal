<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\AuditFormField;
use Storage;

class AuditFormFieldProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        AuditFormField::deleting(function($field) {
            if ($field->tag == "file") {
                $filename = $field->value;
                if (Storage::disk('s3')->has($filename)) {
                    Storage::disk('s3')->delete($filename);
                }
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
