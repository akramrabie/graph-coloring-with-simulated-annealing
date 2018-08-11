<?php
class graph{
    private $adj = array();
    private $coloringSet = array();
    private $countColors = 0;
    private $alpha = null;
    private $temperature = null;
    private $edges = array();
    public $jsCode = '';
    private $temperatureChanges = '';
    private $adjMatrixHtml = '';

    private function getNodeCount(){ return count($this->adj); }
    function addEdge($v, $w){

//        if(!isset($this->adj[$v]) OR is_null($this->adj[$v]))$this->adj[$v] = [];
        array_push($this->adj[$v],  $w);
        if(!isset($this->adj[$w]) OR is_null($this->adj[$w]))$this->adj[$w] = [];
//        var_dump($w, $this->adj);
        array_push($this->adj[$w], $v);// Note: the graph is undirected

        array_push($this->edges, [$v,$w]);


    }

    function SA_coloring($init_temp, $min_temp, $max_temperature, $max_iterations, $alpha, $colorCount){

        $this->temperature = $init_temp;
        $this->countColors = $colorCount;
        $this->alpha = $alpha;
        $this->generateFirstSolution();


        for($i = 0; $i < $max_iterations; $i++)
        {

            $this->nextNeighbour();
            $this->cool();

            if($this->temperature <= $min_temp) break;
            if($this->calculateH() == 0 )  break;

        }

        $this->printGraph();
        $this->printAdjMatrix();
        $this->getCurrentSolutionSet();
        echo $this->adjMatrixHtml;
        echo '<div id="temperatureChanges">temp changes: <br /><br />'.$this->temperatureChanges . '</div>';

        $this->showGraph();
    }
    function generateFirstSolution(){
        for( $i = 0 ; $i <= $this->getNodeCount() ; $i++){
            $this->coloringSet[$i] = rand(0, $this->countColors);
        }
    }
    function calculateH(){
        $badEdgeCount = 0;
        for($i = 0 ; $i < $this->getNodeCount(); $i++){
            {
                foreach($this->edges as $edge){
                    if($this->coloringSet[$edge[0]] == $this->coloringSet[$edge[1]] )
                        $badEdgeCount++;
                }
            }
        }
        return $badEdgeCount;
    }
    function cool(){
        $this->temperature =  $this->temperature - $this->alpha;// linear

        $this->temperatureChanges .= ' ' . $this->temperature. '<br />';
//         $this->temperature =   $temperature * $this->alpha; //
//        $temperature =  $temperature0*(1/(log(k+2)));
    }
    function nextNeighbour(){

        $color = $this->getRandColor();
        $randNode = rand(0, $this->getNodeCount());
        $lastColorOfNode =$this->coloringSet[$randNode];
        if($lastColorOfNode ==  $color)
            $color = ( ($color + 1) > $this->countColors )? $color-1 : $color + 1 ;

        $h_last = $this->calculateH();
        $this->colorTheNode($randNode, $color);
        $h_new = $this->calculateH();

        // accept if $h_new < $h_last
        // if  $h_new > $h_last accept with this probability
        if($h_new  > $h_last  ){
            $p = rand(0,1);
            $dif_h = $h_new - $h_last;

            //if $< exp(...)  accept this solution
            if( $p > exp( - $dif_h / $this->temperature))
                $this->colorTheNode($randNode, $lastColorOfNode);// reject the solution and recolor node to node last color
        }

    }

    private function colorTheNode($node, $color){
        $this->coloringSet[$node] = $color;
    }

    private function getRandColor(){
        return rand(0, $this->countColors);
    }
    public function setNodeCount($count){
        $this->adj = array_fill(0,$count,array());
    }


    //=========print section
    public function getCurrentSolutionSet(){
        $html = '';
        echo '
        <div id="coloringSet"  style="display:none"><br /><br />Coloring Set:<br /><br />';
        foreach ($this->adj as $i=>$node ) {
            echo $i . '     =====> <span style="display:none" class="nodeColor" data-node="'.$i.'" data-color="'.$this->coloringSet[$i].'" ></span>    ' . $this->coloringSet[$i] . '<br />';

        }
        echo '</div>';
        ($this->coloringSet);
    }
    function printGraph(){
        echo '<div id="graphEdgesSimple" style="display: none" ><br /><br />Graph  Connections:<br /><br /> ';

        foreach ($this->adj as $i => $adj ) {
            echo $i . '=>';
            foreach ($adj as $node) {
                echo   ' ------  ' . $node;
            }
            echo '<br />';


        }
        echo '</div>';
    }
    function printAdjMatrix(){
        $this->adjMatrixHtml .= '<div id="adjMatrix"><br /><br />AdjMatrix:<br /><br />';

        foreach ($this->adj as $i => $adj ) {
            $this->adjMatrixHtml .= $i . '=>';
            for($i = 0 ;$i<= $this->getNodeCount(); $i++){
                if(array_search($i,$adj))  $this->adjMatrixHtml .=   '&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp';
                else $this->adjMatrixHtml .= '&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp';
            }

            $this->adjMatrixHtml .= '<br />';
        }

        $this->adjMatrixHtml .= '</div> ';
    }

    function showGraph(){

        echo '
         <script type="text/javascript">
         var i,
            s,
            N = 10,
            E = 20,
            g = {
              nodes: [],
              edges: []
            };


            var nodesColorSet = [];
            var colorSet = ["#ffff00", "#ff5722", "#8bc34a" , "#e91e63" , "#607d8b" , "#009688", "#00bcd4" , "#9e9e9e" ,"#673ab7" , "#f11000"];

            jq("#coloringSet").find(".nodeColor").each(function(i){
                nodesColorSet[jq(this).data("node")] = colorSet[jq(this).data("color")];
            });


            var graphAdjMatrix = JSON.parse("'.json_encode($this->adj).'");

//debugger;
            for(var k = 0 ; i< 20; k++){
                console.log("sd");
            }
            jq(graphAdjMatrix).each(function(i, e){
            console.log(i);
               g.nodes.push({
                    id: "n" + i,
                    label: "Node " + i,
                    x: Math.random(),
                    y: Math.random(),
                    size: 6,
                    color: nodesColorSet[i]
                  });
                });


                var edg = [];
                jq(graphAdjMatrix).each(function(i, e){

                    var source = i;

                    jq(e).each(function(i,e){

                       if(edg.indexOf("e" +source+ i + e) != -1) return;
                       edg.push("e" +source+ i + e);
//                    console.log(edg);

                        g.edges.push({
                            id: "e" +source+ i + e ,
                            source: "n" + source,
                            target: "n" + e,
                            size: Math.random(),
                            color:"#000"
                          });
                    });
                });

              s = new sigma({
                  graph: g,
                  container: "graph-container"
                });


//            debugger;
           /*sigma.parsers.json("data.json", {
                container: "container",
                settings: {
                  defaultNodeColor: "#ec5148"
                }
              });*/
        </script>
        ';
    }
}


//<editor-fold desc="creating graph">
$g1 = new graph();
$nodeCount = 20;
$g1->setNodeCount($nodeCount);



for($i = 0 ; $i< $nodeCount ; $i++){
    $r = rand(0,$nodeCount);

    for($j = 0 ; $j< $r; $j++){
        $randNode = rand(0,$nodeCount);
        $g1->addEdge($i,$randNode);
    }
}
//exit;

//</editor-fold>

/*$g1->firstSolution();
$g1->printGraph();
$g1->getCurrentSolutionSet();*/

echo '<head>
<script src="sigma.js-1.2.1/src/sigma.core.js"></script>
<script src="sigma.js-1.2.1/src/conrad.js"></script>
<script src="sigma.js-1.2.1/src/utils/sigma.utils.js"></script>
<script src="sigma.js-1.2.1/src/utils/sigma.polyfills.js"></script>
<script src="sigma.js-1.2.1/src/sigma.settings.js"></script>
<script src="sigma.js-1.2.1/src/classes/sigma.classes.dispatcher.js"></script>
<script src="sigma.js-1.2.1/src/classes/sigma.classes.configurable.js"></script>
<script src="sigma.js-1.2.1/src/classes/sigma.classes.graph.js"></script>
<script src="sigma.js-1.2.1/src/classes/sigma.classes.camera.js"></script>
<script src="sigma.js-1.2.1/src/classes/sigma.classes.quad.js"></script>
<script src="sigma.js-1.2.1/src/classes/sigma.classes.edgequad.js"></script>
<script src="sigma.js-1.2.1/src/captors/sigma.captors.mouse.js"></script>
<script src="sigma.js-1.2.1/src/captors/sigma.captors.touch.js"></script>
<script src="sigma.js-1.2.1/src/renderers/sigma.renderers.canvas.js"></script>
<script src="sigma.js-1.2.1/src/renderers/sigma.renderers.webgl.js"></script>
<script src="sigma.js-1.2.1/src/renderers/sigma.renderers.svg.js"></script>
<script src="sigma.js-1.2.1/src/renderers/sigma.renderers.def.js"></script>
<script src="sigma.js-1.2.1/src/renderers/webgl/sigma.webgl.nodes.def.js"></script>
<script src="sigma.js-1.2.1/src/renderers/webgl/sigma.webgl.nodes.fast.js"></script>
<script src="sigma.js-1.2.1/src/renderers/webgl/sigma.webgl.edges.def.js"></script>
<script src="sigma.js-1.2.1/src/renderers/webgl/sigma.webgl.edges.fast.js"></script>
<script src="sigma.js-1.2.1/src/renderers/webgl/sigma.webgl.edges.arrow.js"></script>
<script src="sigma.js-1.2.1/src/renderers/canvas/sigma.canvas.labels.def.js"></script>
<script src="sigma.js-1.2.1/src/renderers/canvas/sigma.canvas.hovers.def.js"></script>
<script src="sigma.js-1.2.1/src/renderers/canvas/sigma.canvas.nodes.def.js"></script>
<script src="sigma.js-1.2.1/src/renderers/canvas/sigma.canvas.edges.def.js"></script>
<script src="sigma.js-1.2.1/src/renderers/canvas/sigma.canvas.edges.curve.js"></script>
<script src="sigma.js-1.2.1/src/renderers/canvas/sigma.canvas.edges.arrow.js"></script>
<script src="sigma.js-1.2.1/src/renderers/canvas/sigma.canvas.edges.curvedArrow.js"></script>
<script src="sigma.js-1.2.1/src/renderers/canvas/sigma.canvas.edgehovers.def.js"></script>
<script src="sigma.js-1.2.1/src/renderers/canvas/sigma.canvas.edgehovers.curve.js"></script>
<script src="sigma.js-1.2.1/src/renderers/canvas/sigma.canvas.edgehovers.arrow.js"></script>
<script src="sigma.js-1.2.1/src/renderers/canvas/sigma.canvas.edgehovers.curvedArrow.js"></script>
<script src="sigma.js-1.2.1/src/renderers/canvas/sigma.canvas.extremities.def.js"></script>
<script src="sigma.js-1.2.1/src/renderers/svg/sigma.svg.utils.js"></script>
<script src="sigma.js-1.2.1/src/renderers/svg/sigma.svg.nodes.def.js"></script>
<script src="sigma.js-1.2.1/src/renderers/svg/sigma.svg.edges.def.js"></script>
<script src="sigma.js-1.2.1/src/renderers/svg/sigma.svg.edges.curve.js"></script>
<script src="sigma.js-1.2.1/src/renderers/svg/sigma.svg.labels.def.js"></script>
<script src="sigma.js-1.2.1/src/renderers/svg/sigma.svg.hovers.def.js"></script>
<script src="sigma.js-1.2.1/src/middlewares/sigma.middlewares.rescale.js"></script>
<script src="sigma.js-1.2.1/src/middlewares/sigma.middlewares.copy.js"></script>
<script src="sigma.js-1.2.1/src/misc/sigma.misc.animation.js"></script>
<script src="sigma.js-1.2.1/src/misc/sigma.misc.bindEvents.js"></script>
<script src="sigma.js-1.2.1/src/misc/sigma.misc.bindDOMEvents.js"></script>
<script src="sigma.js-1.2.1/src/misc/sigma.misc.drawHovers.js"></script>
<script src="jquery.js" type="text/javascript"></script>
</head>
<style>
body{margin:0; padding:0;background: whitesmoke;}
body>div>div{
padding:20px;
overflow:auto;
}
#adjMatrix{position:absolute; left: 180px; top:0 ;width: 600px; height: 500px; overflow: auto;  background: #00ffe9;}
#graphEdgesSimple{position:absolute; left: 0; top: 300px ;width: 400px; height: 467px; overflow: auto;background: #00f1ff;}
#coloringSet{position:absolute; left: 0; top: 250px ;width: 400px; height: 300px; overflow: auto}
#temperatureChanges{direction:rtl;position:absolute;width:110px;text-align:left; left: 0px;top: 0 ;height: 100%; overflow: auto;    background: #ecd3ac;}
#graph-container{min-width:600px;min-height:600px; position:absolute;right:50px; top:10px;overflow: visible; padding:20px}
</style>
<body>
<div id="container">
<div id="compute">compute</div>
<div id="graph-container" style=""></div>
';
$g1->SA_coloring(100,0,500,100,0.95,5);
echo '
</div>
</body>';
