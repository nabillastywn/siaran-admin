<?php

namespace App\Charts;

use App\Models\BullyingReport;
use App\Models\ItemsReport;
use App\Models\SaranaReport;
use App\Models\SexualReport;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use ArielMejiaDev\LarapexCharts\PieChart;

class AllReportsChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): PieChart
    {
        $data = [
            BullyingReport::count(),
            ItemsReport::count(),
            SaranaReport::count(),
            SexualReport::count(),
        ];

        return $this->chart->pieChart()
            ->setTitle('Total Reports')
            ->setSubtitle('All Reports Sent to SIARAN System')
            ->addData($data)
            ->setLabels(['Bullying Reports', 'Items Reports', 'Facility Reports', 'Sexual Reports']);
    }
}