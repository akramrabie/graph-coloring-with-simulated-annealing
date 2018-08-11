namespace graph_coloring_yusefi
{
    partial class Form1
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.node_edge_lstbx = new System.Windows.Forms.ListBox();
            this.label1 = new System.Windows.Forms.Label();
            this.colors_lstbx = new System.Windows.Forms.ListBox();
            this.label2 = new System.Windows.Forms.Label();
            this.node_colors_lstbx = new System.Windows.Forms.ListBox();
            this.label3 = new System.Windows.Forms.Label();
            this.button1 = new System.Windows.Forms.Button();
            this.SuspendLayout();
            // 
            // node_edge_lstbx
            // 
            this.node_edge_lstbx.Font = new System.Drawing.Font("Microsoft Sans Serif", 13F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(178)));
            this.node_edge_lstbx.FormattingEnabled = true;
            this.node_edge_lstbx.ItemHeight = 20;
            this.node_edge_lstbx.Location = new System.Drawing.Point(42, 72);
            this.node_edge_lstbx.Name = "node_edge_lstbx";
            this.node_edge_lstbx.Size = new System.Drawing.Size(167, 324);
            this.node_edge_lstbx.TabIndex = 0;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Font = new System.Drawing.Font("Microsoft Sans Serif", 13F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(178)));
            this.label1.Location = new System.Drawing.Point(39, 45);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(64, 22);
            this.label1.TabIndex = 1;
            this.label1.Text = "edges:";
            // 
            // colors_lstbx
            // 
            this.colors_lstbx.Font = new System.Drawing.Font("Microsoft Sans Serif", 13F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(178)));
            this.colors_lstbx.FormattingEnabled = true;
            this.colors_lstbx.ItemHeight = 20;
            this.colors_lstbx.Location = new System.Drawing.Point(267, 72);
            this.colors_lstbx.Name = "colors_lstbx";
            this.colors_lstbx.Size = new System.Drawing.Size(190, 324);
            this.colors_lstbx.TabIndex = 0;
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Font = new System.Drawing.Font("Microsoft Sans Serif", 13F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(178)));
            this.label2.Location = new System.Drawing.Point(264, 45);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(67, 22);
            this.label2.TabIndex = 1;
            this.label2.Text = "Colors:";
            // 
            // node_colors_lstbx
            // 
            this.node_colors_lstbx.Font = new System.Drawing.Font("Microsoft Sans Serif", 13F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(178)));
            this.node_colors_lstbx.FormattingEnabled = true;
            this.node_colors_lstbx.ItemHeight = 20;
            this.node_colors_lstbx.Location = new System.Drawing.Point(491, 72);
            this.node_colors_lstbx.Name = "node_colors_lstbx";
            this.node_colors_lstbx.Size = new System.Drawing.Size(190, 324);
            this.node_colors_lstbx.TabIndex = 0;
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Font = new System.Drawing.Font("Microsoft Sans Serif", 13F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(178)));
            this.label3.Location = new System.Drawing.Point(488, 45);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(115, 22);
            this.label3.TabIndex = 1;
            this.label3.Text = "Node Colors:";
            // 
            // button1
            // 
            this.button1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(128)))), ((int)(((byte)(64)))), ((int)(((byte)(64)))));
            this.button1.Font = new System.Drawing.Font("Microsoft Sans Serif", 13F, System.Drawing.FontStyle.Regular, System.Drawing.GraphicsUnit.Point, ((byte)(178)));
            this.button1.ForeColor = System.Drawing.Color.White;
            this.button1.Location = new System.Drawing.Point(235, 429);
            this.button1.Name = "button1";
            this.button1.Size = new System.Drawing.Size(256, 75);
            this.button1.TabIndex = 2;
            this.button1.Text = "Anneal";
            this.button1.UseVisualStyleBackColor = false;
            this.button1.Click += new System.EventHandler(this.button1_Click);
            // 
            // Form1
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(255)))), ((int)(((byte)(224)))), ((int)(((byte)(192)))));
            this.ClientSize = new System.Drawing.Size(726, 540);
            this.Controls.Add(this.button1);
            this.Controls.Add(this.label3);
            this.Controls.Add(this.label2);
            this.Controls.Add(this.label1);
            this.Controls.Add(this.node_colors_lstbx);
            this.Controls.Add(this.colors_lstbx);
            this.Controls.Add(this.node_edge_lstbx);
            this.Name = "Form1";
            this.Text = "Form1";
            this.Load += new System.EventHandler(this.Form1_Load);
            this.ResumeLayout(false);
            this.PerformLayout();

        }

        #endregion

        private System.Windows.Forms.ListBox node_edge_lstbx;
        private System.Windows.Forms.Label label1;
        private System.Windows.Forms.ListBox colors_lstbx;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.ListBox node_colors_lstbx;
        private System.Windows.Forms.Label label3;
        private System.Windows.Forms.Button button1;
    }
}

