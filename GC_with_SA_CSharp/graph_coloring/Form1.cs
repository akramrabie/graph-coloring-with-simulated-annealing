using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace graph_coloring_yusefi
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private int nodeCount = 0;
        private int[] adj ;
        private int[] coloringSet ;
        private int countColors = 0;
        private double alpha ;
        private double temperature ;
        private List<int[]> edges = new List<int[]>();
        int edgeCount = 0;

        private string temperatureChanges;
        private string adjMatrixHtml ;



        private int getGraphNodeCount() { return this.adj.Length; }
        private void addEdge(int[] a) {
            try
            {
                
                this.adj[a[0]] = 1;
                this.adj[a[1]] = 1;
                this.edgeCount++;

                this.edges.Add(new int[2] { a[0], a[1] });
            }
            catch (Exception e) { MessageBox.Show(e.ToString()); }
            
        }





        private void SA_calculate(float init_temp, float min_temp, int max_iterations,  double alpha)
        {
            
            this.temperature = init_temp;
            this.countColors = colors_lstbx.Items.Count;
            this.alpha = alpha;



            //annealing process

            this.setFirstSolution();

            for (int i = 0; i < max_iterations; i++)
                {

               this.nextNeighbour();
               this.cool();

                if (this.temperature <= min_temp) break;
                if (this.getEnergy() == 0 )  break;

              }

            this.showSolution();

        }





        private void showSolution() {
            node_colors_lstbx.Items.Clear();
            for (int i = 0; i < this.nodeCount; i++)
            {
                node_colors_lstbx.Items.Add("Node " + i + " : color " + this.coloringSet[i]);
            }

        }

        private void colorTheNode(int node, int color){
            this.coloringSet[node] = color;
         }

        private void nextNeighbour()
        {

            Random rand = new Random();
            int color = rand.Next(0, this.countColors);
            int randNode = rand.Next(0, this.nodeCount);

            int lastColorOfNode = this.coloringSet[randNode];

            if ( lastColorOfNode ==  color)
              color = ((color + 1) > this.countColors )? color - 1 : color + 1;

            double h_last = this.getEnergy();
            this.colorTheNode(randNode, color);
            double h_new = this.getEnergy();

            // accept if $h_new < $h_last
            // if  $h_new > $h_last accept with this probability
            if (h_new > h_last  ){
              double p = rand.Next(0, 100) / 100;
              double dif_h = h_new - h_last;

                //if $< exp(...)  accept this solution
                if ( p > Math.Exp(- dif_h / this.temperature))
                this.colorTheNode(randNode, lastColorOfNode);// reject the solution and recolor node to node last color
            }


        }
        private void cool() {
            this.temperature = this.temperature * this.alpha;
        }

        private double getEnergy() {
            int badEdgeCount = 0;
            for (int i = 0; i < this.edgeCount - 1; i++)
            {
                if (this.coloringSet[this.edges[i][0]]== this.coloringSet[this.edges[i][1]]) badEdgeCount++;
            }
            return badEdgeCount;
        }

        private void createGraph(int nodeCount, int colorCount)

        private void setFirstSolution() {

            Random rand = new Random();
            node_colors_lstbx.Items.Clear();

            for (int i = 0; i < this.nodeCount ; i++)
            {
                int randColor  = rand.Next(0, colors_lstbx.Items.Count-1 );
                this.coloringSet[i]= randColor;

                node_colors_lstbx.Items.Add("Node " + i + " : color " + randColor);
            }
        }
        private void button1_Click(object sender, EventArgs e)
        {

            this.createGraph(6, colors_lstbx.Items.Count);

            for (int i = 0; i < node_edge_lstbx.Items.Count - 1; i++)
            {
                
                int[] intAdjNodes = Array.ConvertAll((node_edge_lstbx.Items[i].ToString()).Split(','), int.Parse);
                this.addEdge(intAdjNodes);
            }


            this.SA_calculate(100, 0, 500, 0.001);

        }



        private void Form1_Load(object sender, EventArgs e)
        {
            colors_lstbx.Items.Add(0);
            colors_lstbx.Items.Add(1);
            colors_lstbx.Items.Add(2);
            colors_lstbx.Items.Add(3);
            colors_lstbx.Items.Add(4);


            node_edge_lstbx.Items.Add("0,2");
            node_edge_lstbx.Items.Add("0,3");
            node_edge_lstbx.Items.Add("0,1");
            node_edge_lstbx.Items.Add("1,2");
            node_edge_lstbx.Items.Add("1,3");
            node_edge_lstbx.Items.Add("1,4");
            node_edge_lstbx.Items.Add("2,5");
            node_edge_lstbx.Items.Add("2,4");
            node_edge_lstbx.Items.Add("3,4");
            node_edge_lstbx.Items.Add("4,5");
   

        }
    }
}
