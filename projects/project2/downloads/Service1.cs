using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Diagnostics;
using System.Linq;
using System.ServiceProcess;
using System.Text;
using System.Threading.Tasks;

namespace WindowsService1
{
    public partial class GrandTheftAutoPriority : ServiceBase
    {
        public GrandTheftAutoPriority()
        {
            InitializeComponent();
        }

        void StartTimer()
        {
            System.Timers.Timer checkInterval = new System.Timers.Timer();
            checkInterval.Interval = 10000;
            checkInterval.AutoReset = true;
            checkInterval.Elapsed += CheckProcesses;
            checkInterval.Enabled = true;
        }

        void CheckProcesses(Object source, System.Timers.ElapsedEventArgs e)
        {
            Process[] processList = Process.GetProcesses();
            foreach(Process processA in processList)
            {
                if(processA.ProcessName == "GTA5" || processA.ProcessName == "ScpService")
                {
                    processA.PriorityClass = ProcessPriorityClass.AboveNormal;
                }
            }
        }

        protected override void OnStart(string[] args)
        {
            StartTimer();
        }

        protected override void OnStop()
        {
        }
    }
}
