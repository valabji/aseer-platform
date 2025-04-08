<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RateLimitInsertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $tries = 2;
    public $timeout = 0.1;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data= $data;
    }

    public function handle()
    {
        $data = $this->data;

        // احصل على البلد
        $country = (new \UserSystemInfoHelper)->get_country_from_ip($data['ip']);

        // حفظ في جدول rate_limits
        $rateLimit = \App\Models\RateLimit::create([
            'traffic_landing'    => $data['traffic_landing'],
            'domain'             => $data['prev_domain'],
            'prev_link'          => $data['prev_url'],
            'ip'                 => $data['ip'],
            'country_code'       => $country['country_code'],
            'country_name'       => $country['country'],
            'agent_name'         => $data['agent_name'],
            'user_id'            => $data['user_id'],
            'browser'            => $data['browser'],
            'device'             => $data['device'],
            'operating_system'   => $data['operating_system'],
        ]);

        // حفظ التفاصيل في جدول rate_limit_details
        \App\Models\RateLimitDetail::create([
            'rate_limit_id' => $rateLimit->id,
            'url'           => $data['traffic_landing'],
            'user_id'       => $data['user_id'],
            'ip'            => $data['ip'],
        ]);
    }

}
