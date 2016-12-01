<!DOCTYPE html>
<html lang="en">
<head>
	<title> Portfolio Projects - Project 2 </title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="../../style.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!--Font Awesome by Dave Gandy - http://fontawesome.io-->
	<!-- <i> tags used for glyphicons (styling) so technically incorrect use of HTML but hidden from accessibility with "aria-hidden=true" attribute-->
	<link rel="stylesheet" type="text/css" href="../../font-awesome-4.7.0/css/font-awesome.min.css" />
	<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
</head>
<body>
	<header id="branding">
		<h1 class="row col-12"> Project 2 </h1>
		<nav id="navigation">
			<h2> Navigation </h2>
			<ul class="row">
				<li class="col-3"><a href="../../index.php"><span class="fa fa-home" aria-hidden="true"></span> Home </a></li>
				<li class="col-3"><a href="../../personal.php"><span class="fa fa-user" aria-hidden="true"></span> Personal Bio </a></li>
				<li class="title-nested col-3"><a href="../index.php"><span class="fa fa-code" aria-hidden="true"></span> Projects </a>
					<ul class="nested-list">
						<li><a href="../project1/"> <abbr title="Universal Serial Bus">USB</abbr> Backup </a></li>
						<li><a href="index.php"> <abbr title="Grand Theft Auto">GTA</abbr> Graphics Fix </a></li>
						<li><a> More Coming Soon! </a></li>
					</ul>
				</li>
				<li class="col-3"><a href="../../contact.php"><span class="fa fa-address-book" aria-hidden="true"></span> Contact me </a></li>
			</ul>
		</nav>
	</header>
	<main id="project2" tabindex="-1">
		<!-- Content starts here -->
		<aside class="aside-4">
			<h2> <abbr title="Grand Theft Auto">GTA</abbr> Graphics Fix (C#) </h2>
			<p>
				This page showcases a windows service I developed to solve an annoying problem and learn the simplicity of C#.
			</p>
			<ul>
				<li><a href="#source">Source</a></li>
				<li><a href="#use">Usage</a></li>
				<li><a href="#downloads">Downloads</a></li>
				<li><a href="#description">Description</a></li>
			</ul>
		</aside>
		<section id="source">
			<h3><span class="fa fa-code" aria-hidden="true"></span> Source Code </h3>
			<!--<details> tag not supported in many browsers yet so this should do -->
			<p class="details">
				This code only works on my PC and <em>may behave differently</em> if compiled and installed on a different
				machine. The service when running along side the game <strong>will definitely slow down all other
				programs</strong> running on the machine.
			</p>
			<h4>Service File (Service1.cs)</h4>
			<div class="code">
				<pre class="prettyprint linenums">
					<code class="lang-cs">
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
					if(processA.ProcessName == &quot;GTA5&quot; || processA.ProcessName == &quot;ScpService&quot;)
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
					</code>
				</pre>
			</div>
			<h4>Service Design File (ProjectInstaller.Designer.cs)</h4>
			<div class="code">
				<pre class="prettyprint linenums">
					<code class="lang-cs">
	namespace WindowsService1
	{
		partial class ProjectInstaller
		{
		  ///Code Generated by Visual Studio to describe the service.
			/// &lt;summary&gt;
			/// Required designer variable.
			/// &lt;/summary&gt;
			private System.ComponentModel.IContainer components = null;

			/// &lt;summary&gt;
			/// Clean up any resources being used.
			/// &lt;/summary&gt;
			/// &lt;param name=&quot;disposing&quot;&gt;true if managed resources should be disposed; otherwise, false.&lt;/param&gt;
			protected override void Dispose(bool disposing)
			{
				if (disposing &amp;&amp; (components != null))
				{
					components.Dispose();
				}
				base.Dispose(disposing);
			}

			#region Component Designer generated code

			/// &lt;summary&gt;
			/// Required method for Designer support - do not modify
			/// the contents of this method with the code editor.
			/// &lt;/summary&gt;
			private void InitializeComponent()
			{
				this.serviceProcessInstaller1 = new System.ServiceProcess.ServiceProcessInstaller();
				this.serviceInstaller1 = new System.ServiceProcess.ServiceInstaller();
				//
				// serviceProcessInstaller1
				//
				this.serviceProcessInstaller1.Account = System.ServiceProcess.ServiceAccount.LocalSystem;
				this.serviceProcessInstaller1.Password = null;
				this.serviceProcessInstaller1.Username = null;
				//
				// serviceInstaller1
				//
				this.serviceInstaller1.Description = &quot;Check to see if GTAV and SCP driver have launched every 10s and set there priorit&quot; +
		&quot;y to high.&quot;;
				this.serviceInstaller1.DisplayName = &quot;GTAV Priority Changer&quot;;
				this.serviceInstaller1.ServiceName = &quot;GrandTheftAutoPriority&quot;;
				this.serviceInstaller1.StartType = System.ServiceProcess.ServiceStartMode.Automatic;
				//
				// ProjectInstaller
				//
				this.Installers.AddRange(new System.Configuration.Install.Installer[] {
				this.serviceProcessInstaller1,
				this.serviceInstaller1});

			}

			#endregion

			private System.ServiceProcess.ServiceProcessInstaller serviceProcessInstaller1;
			private System.ServiceProcess.ServiceInstaller serviceInstaller1;
		}
	}
					</code>
				</pre>
			</div>
		</section>
		<section id="use">
			<h3><span class="fa fa-terminal" aria-hidden="true"></span> Usage </h3>
			<p>
				As this was only developed for my use I don't have any proper usage or installation instructions. Although I
				followed the Microsoft Developers tutorial on how to compile and install a service made with Visual Studio and
				C#.
			</p>
		</section>
		<section id="downloads">
			<h3><span class="fa fa-download" aria-hidden="true"></span> Downloads</h3>
			<ul>
				<li><a href="downloads/Service1.cs" target="_blank" title="opens new window">Service File (Service1.cs)</a></li>
				<li><a href="downloads/ProjectInstaller.Designer.cs" target="_blank" title="opens new window">Service Design (ProjectInstaller.Designer.cs)</a></li>
				<li><a href="downloads/project.zip" target="_blank" title="opens new window">Visual Studio Project (project.zip)</a></li>
				<li><a href="images/gta2.jpg" target="_blank" title="opens new window">Game Screenshot (gta2.jpg)</a></li>
			</ul>
		</section>
		<section id="description">
			<h3><span class="fa fa-info-circle" aria-hidden="true"></span> Description </h3>
			<p>
				This program is written as an installable Microsoft Windows service. Once installed it will check the
				system every 10 seconds to see if either the <abbr title="Grand Theft Auto 5">GTA V</abbr>
				<abbr title="Executable">exe</abbr> has been launched or if the
				<abbr title="Scarlet Crush Productions">SCP</abbr> <abbr title="Play Station 3">PS3</abbr> controller driver
				has been launched. If either of these have it will set the process priority to high.
				This solved a graphics issue where textures were not loading into the game quick enough <a href="https://www.reddit.com/r/pcmasterrace/comments/32ib6y/anyone_else_getting_these_texture_bugs_gta_v/" target="_blank" title="opens new window">(pop-in example [reddit.com thread by:Jakey120])</a>, although just changing
				the priority of the game executable slowed down the controller driver causing bad latency. This is why the
				driver priority also needed to be changed.
			</p>
			<figure>
				<img src="images/gta2.jpg" height="450" width="800" alt="Screenshot of the GTA V game"/>
				<figcaption>
					This is what the should look like after the fix is applied. All the textures have loaded in properly and
					the performance is acceptable.
				</figcaption>
			</figure>
		</section>
		<!-- Content ends here -->
	</main>
	<footer id="contact">
		<address>
			Created by some <a href="mailto:k.j.watson1@edu.salford.ac.uk">guy.</a>
		</address>
		<p>
			<?php
				echo "Last Modified: " . date("d/m/y H:m",filemtime(__FILE__));
			?>
		</p>
		<nav id="bottom-nav">
			<ul>
				<li><a href="#">Back to the top.</a></li>
				<li id="back-button"><a href="../project1/">Previous project.</a></li>
			</ul>
		</nav>
	</footer>
</body>
</html>
