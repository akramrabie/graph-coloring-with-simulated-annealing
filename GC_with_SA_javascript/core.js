

var adj = [[]];
var coloringSet = [];
var countColors = 0;
var alpha = null;
var temperature = null;
var edges = [];
var jsCode = '';
var temperatureChanges = '';

function getNodeCount(){ return adj.length; }
function addEdge( v,  w){
    if(!adj[v]) adj[v] = [];
    adj[v].push( w);
    if(!adj[w]) adj[w] = [];
    adj[w].push( v);
    edges.push([ v, w]);
}

function SA_coloring( init_temp,  min_temp,  max_iterations,  alphaa){

    temperature =  init_temp;
    countColors = 5;
     alpha =  alphaa;
    setFirstSolution();

    for( i = 0;  i <  max_iterations;  i++)
    {
        nextNeighbour();
        cool();
        if(temperature <=  min_temp) break;
        if(calculateH() == 0 )  break;
    }
//debugger;
    printGraph();
    printAdjMatrix();
    getCurrentSolutionSet();

}
function setFirstSolution(){
    for( var i = 0 ; i <= getNodeCount() ; i++){
        coloringSet[ i] = getRandColor();
    }
}
function calculateH(){
    var badEdgeCount = 0;
    for(var i = 0 ; i < getNodeCount(); i++){
        {
            jq(edges).each(function(i,  edge){
            if(coloringSet[edge[0]] == coloringSet[edge[1]] )
                badEdgeCount++;
            });
        }
    }
    return badEdgeCount;
}
function cool(){
    temperature =  temperature - alpha;// linear
    jq("#temperatureChanges").html(temperature);
//         temperature =    temperature * alpha; //
//         temperature =   temperature0*(1/(log(k+2)));
}
function nextNeighbour(){

    var color = getRandColor();
    var randNode = Math.floor(Math.random() * getNodeCount()) ;
    var lastColorOfNode =coloringSet[randNode];
    if(lastColorOfNode ==   color)
        color = ( (color + 1) > countColors )? color-1 :  color + 1 ;

    var h_last = calculateH();
    colorTheNode( randNode,  color);
     h_new = calculateH();

    // accept if  h_new <  h_last
    // if   h_new >  h_last accept with this probability
    if( h_new  >  h_last  ){
         p = Math.random() ;
         var dif_h =  h_new -  h_last;

        //if  < exp(...)  accept this solution
        if(  p > Math.exp( -  dif_h / temperature))
            colorTheNode( randNode,  lastColorOfNode);// reject the solution and recolor node to node last color
    }

}

 function colorTheNode( node,  color){
    coloringSet[ node] =  color;
}

 function getRandColor(){
     return  Math.floor(Math.random() * countColors) ;

}
 function setNodeCount( count){
    adj = [];
}


//=========print section
function getCurrentSolutionSet(){
    var htmlTex = '';

    jq(adj).each(function(i){

        htmlTex += '<span style="color: red; font-weight: bold">'+ i + '</span>  =>   ' + coloringSet[ i] + '<br />';

    });

    jq("#coloringSet").html(htmlTex);
    
}
function printGraph(){

    var htmlText  = ' ';
    jq(adj).each(function(i, adjNode){
        htmlText +='<span style="color: red; font-weight: bold">'+ i + '</span>  =>   ' ;

        jq(adjNode ).each(function(node) {
            htmlText +=    node + ' , ' ;
            });

        htmlText +='<br />';
    });

    jq("#graphEdgesSimple").html(htmlText);
}
function printAdjMatrix(){
    var adjMatrixHtml = '';
    jq(adj).each(function(  i ,  adjNode ) {
        adjMatrixHtml +=  '<span style="color:red; font-weight: bold;">' +i + '</span>';
        for( i = 0 ; i<= getNodeCount();  i++){
            //debugger;
            var found = adjNode.indexOf(i);

                if(found != -1)
                adjMatrixHtml +=   '&nbsp&nbsp&nbsp1&nbsp&nbsp&nbsp';
            else adjMatrixHtml += '&nbsp&nbsp&nbsp0&nbsp&nbsp&nbsp';
        }

        adjMatrixHtml += '<br />';
    });

    adjMatrixHtml += '</div> ';


    jq('#adjMatrix').html(adjMatrixHtml);
}



jq(function(){
     //setNodeCount(10);

     addEdge(0,2);
     addEdge(0,3);
     addEdge(1,2);
     addEdge(1,3);
     addEdge(1,4);
     addEdge(3,2);
     addEdge(4,5);
     addEdge(4,6);
     addEdge(4,3);
     addEdge(6,7);
     addEdge(6,3);
     addEdge(7,8);
     addEdge(7,1);
     addEdge(7,9);
     addEdge(8,9);
    SA_coloring(100,0,500,0.001)

});