<?php

require_once('C:/xampp/htdocs/Pregunlam/jpgraph-4.4.2/src/jpgraph.php');
require_once('C:/xampp/htdocs/Pregunlam/jpgraph-4.4.2/src/jpgraph_bar.php');

class BarChartGenerator
{
    public function __construct() {

    }

    public function generateChart($data, $labels, $title, $width, $height, $filePath = null) {


        $graph = new Graph($width, $height, 'auto');
        $graph->SetScale("textlin");

        $graph->title->Set($title);
        $graph->xaxis->SetTickLabels($labels);

        $barPlot = new BarPlot($data);
        $barPlot->SetFillColor(['#cc1111', '#11cccc', '#1111cc', '#ffdd44', '#44ff99']);

        $graph->Add($barPlot);

        if ($filePath) {
            $graph->Stroke($filePath);
        } else {
            $graph->Stroke();
        }
    }
}
