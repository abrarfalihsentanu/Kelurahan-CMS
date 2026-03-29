<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use App\Models\Complaint;
use App\Models\PpidRequest;
use App\Models\Contact;
use App\Models\Page;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $keys = [
                'site_name',
                'site_tagline',
                'parent_org',
                'province',
                'phone',
                'email',
                'whatsapp',
                'address',
                'address_short',
                'service_hours',
                'ikm_score',
                'ikm_period',
                'instagram',
                'facebook',
                'youtube',
                'twitter',
                'footer_description',
                'footer_credit'
            ];

            $settings = [];
            foreach ($keys as $key) {
                $settings[$key] = Setting::get($key);
            }

            $view->with('settings', $settings);
        });

        // Share published pages with frontend layout
        View::composer('layouts.app', function ($view) {
            $view->with('navPages', Page::published()->ordered()->get());
        });

        // Share unread counts with admin layout
        View::composer('admin.layouts.app', function ($view) {
            $view->with([
                'unreadComplaints' => Complaint::where('is_read', false)->count(),
                'unreadPpidRequests' => PpidRequest::where('is_read', false)->count(),
                'unreadContacts' => Contact::where('is_read', false)->count(),
            ]);
        });
    }
}
