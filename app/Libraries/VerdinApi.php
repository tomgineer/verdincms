<?php namespace App\Libraries;
use App\Models\AnalyticsModel;

class VerdinApi {

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

public function getMonitoringData() {
    $analytics = new AnalyticsModel();
    $live = $analytics->getLiveData();
    $overview = $analytics->getOverviewData();

    $averages = $overview['averages'] ?? [];
    $growth = $overview['growth'] ?? [];
    $content = $overview['content'] ?? [];
    $system = $overview['system'] ?? [];
    $newsletterCount = $this->db->table('newsletter')->countAllResults();

    $data = [
        'server' => base_url(),
        'insights' => [
            'visitorsNow' => [
                'title' => 'Visitors Now',
                'value' => $live['usersOnline'] ?? 0,
                'desc'  => 'Visitors Currently on Server'
            ],
            'visitorsToday' => [
                'title' => 'Visitors Today',
                'value' => $live['visitorsToday'] ?? 0,
                'desc'  => 'Visitors Today'
            ],
            'hitsToday' => [
                'title' => 'Hits Today',
                'value' => $live['hitsToday'] ?? 0,
                'desc'  => 'Hits Today'
            ],
            'visitorsTotal' => [
                'title' => 'Visitors Total',
                'value' => $growth['Total Visitors'] ?? 0,
                'desc'  => 'Visitors Total'
            ],
            'hitsTotal' => [
                'title' => 'Hits Total',
                'value' => $growth['Total Views'] ?? 0,
                'desc'  => 'Hits Total'
            ],
            'visitorsPerDay' => [
                'title' => 'Visitors per Day',
                'value' => $averages['Visitors per Day'] ?? 0,
                'desc'  => 'Estimation'
            ],
            'visitorsPerMonth' => [
                'title' => 'Visitors per Month',
                'value' => $averages['Visitors per Month'] ?? 0,
                'desc'  => 'Estimation'
            ],
            'visitorsPerYear' => [
                'title' => 'Visitors per Year',
                'value' => $averages['Visitors per Year'] ?? 0,
                'desc'  => 'Estimation'
            ],
            'posts' => [
                'title' => 'Posts',
                'value' => $content['Total Posts'] ?? 0,
                'desc'  => 'Total Posts'
            ],
            'pages' => [
                'title' => 'Pages',
                'value' => $content['Pages'] ?? 0,
                'desc'  => 'Total Pages'
            ],
            'photos' => [
                'title' => 'Photos',
                'value' => $system['Photos'] ?? 0,
                'desc'  => 'Total Photos'
            ],
            'growthLast15d' => [
                'title' => 'Current Period',
                'value' => $growth['Visitors (Recent 15 Days)'] ?? 0,
                'desc'  => 'Visitors in the last 15 days'
            ],
            'growthPrevious15d' => [
                'title' => 'Previous Period',
                'value' => $growth['Visitors (Previous 15 Days)'] ?? 0,
                'desc'  => 'Visitors in the 15 days before the current period'
            ],
            'growth' => [
                'title' => 'Growth Rate',
                'value' => $growth['Growth Rate'] ?? 0,
                'desc'  => 'Change vs previous 15-day period'
            ],
            'newsletter' => [
                'title' => 'Newsletter',
                'value' => $newsletterCount ?? 0,
                'desc'  => 'Subscribers'
            ],
        ]
    ];

    return $data;

}

} // ─── End of Class ───




