<?php

require_once('C:/xampp/htdocs/Pregunlam/vendor/jpgraph-4.4.2/src/jpgraph.php');
require_once('C:/xampp/htdocs/Pregunlam/vendor/jpgraph-4.4.2/src/jpgraph_bar.php');
require_once('C:/xampp/htdocs/Pregunlam/vendor/jpgraph-4.4.2/src/jpgraph_pie.php');
require_once('C:/xampp/htdocs/Pregunlam/vendor/jpgraph-4.4.2/src/jpgraph_pie3d.php');

class ChartGenerator
{


    public function __construct() {}

    public function generateBarChart($data, $labels, $title, $width, $height, $filePath = null) {
        $graph = new Graph($width, $height, 'auto');
        $graph->SetScale("textlin");

        $graph->title->Set($title);
        $graph->xaxis->SetTickLabels($labels);

        $barPlot = new BarPlot($data);
        $graph->Add($barPlot);

        if ($filePath) {
            $graph->Stroke($filePath);
        } else {
            $graph->Stroke();
        }
    }

    public function generatePieChart($data, $labels, $title, $width, $height, $filePath = null) {
        $graph = new PieGraph($width, $height);
        $graph->title->Set($title);

        $piePlot = new PiePlot($data);
        $piePlot->SetLegends($labels);

        $graph->Add($piePlot);

        if ($filePath) {
            $graph->Stroke($filePath);
        } else {
            $graph->Stroke();
        }
    }

}

