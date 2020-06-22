<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigFetchController extends Controller
{
    /**
     * Fetch the system.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetch()
    {
        return response()->json([
            'versions' => $this->getVersionSettings(),
            'routes' => $this->getRoutes(),
            'settings' => $this->getSettings(),
        ]);
    }

    protected function getRoutes()
    {
        return array_merge($this->getUserRoutes());
    }

    protected function getUserRoutes()
    {
        return [
            'api.resources.fetch' => route('api.resources.fetch'),
            'api.fetch.config' => route('api.fetch.config'),
            // 'api.device-token.store' => route('api.device-token.store'),

            'web.frontliner.password.email' => route('web.frontliner.password.email'),

            'api.login' => route('api.login'),
            'api.logout' => route('api.logout'),
            'api.resources.dashboard' => route('api.resources.dashboard'),
            'api.walkin.store' => route('api.walkin.store'),
            'api.survey-experience.answer.store' => route('api.survey-experience.answer.store'),
            'api.new.guest.store' => route('api.new.guest.store'),
            'api.remark.store' => route('api.remark.store'),
            'api.feedback.store' => route('api.feedback.store'),
            'api.scan.qr' => route('api.scan.qr'),

            'api.guest.fetch' => route('api.guest.fetch'),

            'api.sync' => route('api.sync'),
            // 'api.register' => route('api.register'),
            // 'api.verification.resend' => route('api.verification.resend'),

            'api.frontliner.details.update' => route('api.frontliner.details.update'),
            'api.frontliner.start.visit' => route('api.frontliner.start.visit'),
            'api.bookings.fetch' => route('api.bookings.fetch'),
            'api.bookings.remaining-seat' => route('api.bookings.remaining-seat'),
            'api.bookings.representative.update' => route('api.bookings.representative.update'),

            'api.violation.store' => route('api.violation.store'),

            'api.notifications.fetch' => route('api.notifications.fetch'),
            'api.notifications.read' => route('api.notifications.read'),
            'api.device-token.store' => route('api.device-token.store'),
        ];
    }

    protected function getVersionSettings() {
        return [
            'ios' => [
                'stable_version' => config('api.ios.stable_version'),
                'minimum_version' => config('api.ios.minimum_version'),
                'message' => 'Your App is outdated please download latest version! Please download the latest version <a href="https://play.google.com/store/apps/details?id=com.android.chrome" class="white--text" target="_blank">here</a>',
            ],
            'android' => [
                'stable_version' => config('api.android.stable_version'),
                'minimum_version' => config('api.android.minimum_version'),
                'message' => 'Your App is outdated please download latest version! Please download the latest version <a href="https://play.google.com/store/apps/details?id=com.android.chrome" class="white--text" target="_blank">here</a>',
            ],
        ];
    }

    protected function getSettings() {
        return [
            'terms' => '<p>This website considers the protection of your personal information a top priority. Our policies regarding the collection, use and disclosure of information collected from you is subject to the laws of the Philippines.</p>

                    <p>1. We are responsible only for the personal information under our control. But if the content provided by our service has content or web links that lead to illegal or adult oriented information, we are not by any litigation responsible for it as we do not control or monitor the content or the privacy practices of magazines and other websites.</p>

                    <p>2. While requesting or publishing content through this website, you will be requested to authenticate details about your name, email, etc. Of course, you have the freedom to disclose or not disclose optional information about you.</p>

                    <p>3. This website holds the right to store information regarding your usage of the service and may share these with third parties including publishers.</p>

                    <p>4. Your user account is protected by a password selected by you.</p>

                    <p>5. We will disclose your personal information, only with your consent and not otherwise, unless demanded by law.</p>

                    <p>6. We collect personal information by fair and lawful means. And such collected information serves only limited purposes, like meeting the demands of this website user profile as set out in our company policy.</p>

                    <p>7. We protect your personal information by security safeguards depending on the sensitivity of the information collected.</p>

                    <p>This Privacy Policy is effective as of October 8, 2019.</p>',
        ];
    }
}
