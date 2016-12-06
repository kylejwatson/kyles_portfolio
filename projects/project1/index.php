<!DOCTYPE html>
<html lang="en">
<head>
	<title> Portfolio Projects - Project 1 </title>
	<meta charset="UTF-8" />
	<meta name="keywords" content="Portfolio, Student, Developer, C++, USB">
	<meta name="description" content="A simple portfolio to show off projects and attributes.">
	<meta name="author" content="Kyle Watson">
	<link rel="stylesheet" type="text/css" href="../../style.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!--Font Awesome by Dave Gandy - http://fontawesome.io-->
	<!-- <i> tags used for glyphicons (styling) so technically incorrect use of HTML but hidden from accessibility with "aria-hidden=true" attribute-->
	<link rel="stylesheet" type="text/css" href="../../font-awesome-4.7.0/css/font-awesome.min.css" />
	<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
</head>
<body>
	<header id="branding">
		<h1 class="row col-12"> Project 1 </h1>
		<nav id="navigation">
			<h2> Navigation </h2>
			<ul class="row">
				<li class="col-3"><a href="../../index.php"><span class="fa fa-home" aria-hidden="true"></span> Home </a></li>
				<li class="col-3"><a href="../../personal.php"><span class="fa fa-user" aria-hidden="true"></span> Personal Bio </a></li>
				<li class="title-nested col-3"><a href="../index.php"><span class="fa fa-code" aria-hidden="true"></span> Projects </a>
					<ul class="nested-list">
						<li><a href="index.php"> <abbr title="Universal Serial Bus">USB</abbr> Backup </a></li>
						<li><a href="../project2/"> <abbr title="Grand Theft Auto">GTA</abbr> Graphics Fix </a></li>
						<li><a> More Coming Soon! </a></li>
					</ul>
				</li>
				<li class="col-3"><a href="../../contact.php"><span class="fa fa-address-book" aria-hidden="true"></span> Contact me </a></li>
			</ul>
		</nav>
	</header>
	<main id="project1" tabindex="-1">
		<!-- Content starts here -->
		<aside class="aside-4">
			<h2> <abbr title="Universal Serial Bus">USB</abbr> Backup (C++) </h2>
			<p>
				This page showcases a project I am currently working on in order to learn
				more about C++ and it will also have practical uses. It is currently only
				in pre-alpha.
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
			<p class="details">
				This code is a <em>work in progress</em> and many features will be added as well as errors to be expected.
			</p>
			<h4>Main C++ File (boosteg.cpp)</h4>
			<div class="code">
				<pre class="prettyprint linenums">
					<code class="lang-cpp">
	#include &lt;iostream&gt;
	#include &lt;iterator&gt;
	#include &lt;algorithm&gt;
	#include &lt;boost/filesystem.hpp&gt;
	using namespace std;
	using namespace boost::filesystem;
	bool copyDir(boost::filesystem::path const &amp; source,
	 boost::filesystem::path const &amp; destination);
	void backUpEdited(path workPath, path altPath);

	int main()
	{
		path kyleMediaPath (&quot;/media/kyle&quot;);
		path stcMediaPath (&quot;/media/stc905&quot;);
		path workingMediaPath;
		path webLaptopSoftPath (&quot;/home/kyle/Documents/Software_Eng/Web_Dev&quot;);
		path progLaptopSoftPath (&quot;/home/kyle/Documents/Software_Eng/Programming&quot;);
		path dbsLaptopSoftPath (&quot;/home/kyle/Documents/Software_Eng/Databases&quot;);
		const string UBTDEV = &quot;/UBUNTU 16_0&quot;;
		const string WINDEV = &quot;/J_CCSA_X64FRE_EN-US_DV5&quot;;
		const string PROG = &quot;/Software Eng/Programming&quot;;
		const string WEB = &quot;/Software Eng/Web Dev&quot;;
		const string DBS = &quot;/Software Eng/Databases&quot;;
		path testpath (&quot;/media/kyle/UBUNTU 16_0/Software Eng/Programming/testfold&quot;);
		path testpath1 (&quot;/media/kyle/J_CCSA_X64FRE_EN-US_DV5/Software Eng/Programming/testfold&quot;);
		cout &lt;&lt; copyDir(testpath,testpath1) &lt;&lt; endl;
		try{
			if(exists(kyleMediaPath)){
				workingMediaPath = kyleMediaPath;
				cout &lt;&lt; &quot;Kyle Media Path&quot; &lt;&lt; endl;
			}else if(exists(stcMediaPath)){
				workingMediaPath = stcMediaPath;
				cout &lt;&lt; &quot;STC Media Path&quot; &lt;&lt; endl;
			}else{
				cout &lt;&lt; &quot;No recognisable /media/ path exiting&quot; &lt;&lt; endl;
				return 1;
			}
			directory_iterator end_itr;
			vector&lt;string&gt; dirs;
			for (directory_iterator itr(workingMediaPath); itr != end_itr; itr++){
				string pathToString = itr-&gt;path().string();
				path workingDevPath;
				path altDevPath;
				if(pathToString == workingMediaPath.string()+ UBTDEV){
					workingDevPath = path(workingMediaPath.string() + UBTDEV);
					altDevPath = path(workingMediaPath.string() + WINDEV);
				}else if(pathToString == workingMediaPath.string() +WINDEV){
					altDevPath = path(workingMediaPath.string() + UBTDEV);
					workingDevPath = path(workingMediaPath.string() + WINDEV);
				}else{
					cout &lt;&lt; &quot;No media inserted, exiting&quot; &lt;&lt; endl;
					return 1;
				}
				cout &lt;&lt; &quot;Working path is: &quot; + workingDevPath.string() &lt;&lt; endl;
				path devProgPath (workingDevPath.string() + PROG);
				path devWebPath (workingDevPath.string() + WEB);
				path devDBSPath (workingDevPath.string() + DBS);
				if(exists(altDevPath)){
					path altDevProgPath (altDevPath.string() + PROG);
					path altDevWebPath (altDevPath.string() + WEB);
					path altDevDBSPath (altDevPath.string() + DBS);
					backUpEdited(devProgPath, altDevProgPath);
				}
			}
		}
		catch (const filesystem_error&amp; ex){
			cout &lt;&lt; ex.what() &lt;&lt; '\n';
		}
		return 0;
	}

	void backUpEdited(path workPath, path altPath){
		try{
			directory_iterator end_itr;
			for(directory_iterator itr(altPath); itr != end_itr; itr++){
				if(is_directory(itr-&gt;path())){
					string endOfPath = itr-&gt;path().string().substr(altPath.string().length());
					cout &lt;&lt; &quot;End of Path: &quot; &lt;&lt; endl;;
					cout &lt;&lt; endOfPath &lt;&lt; endl;
					path dupPath (workPath.string()+endOfPath);
					cout &lt;&lt; &quot;Dup Path: &quot; &lt;&lt; endl;
					cout &lt;&lt; dupPath.string() &lt;&lt; endl;
					if(exists(dupPath)){
						if(last_write_time(dupPath) != last_write_time(itr-&gt;path())){
							cout &lt;&lt; &quot;Last Mod Dup&quot;; cout &lt;&lt; last_write_time(dupPath) &lt;&lt; endl;
							time_t now = time(0);
							cout &lt;&lt; ctime(&amp;now) &lt;&lt; endl;
							path newPath (dupPath.string() + &quot;_&quot; + ctime(&amp;now));
							cout &lt;&lt; copyDir(itr-&gt;path(),newPath) &lt;&lt; endl;
						}
					}else{
						copyDir(itr-&gt;path(),dupPath);
						cout &lt;&lt; &quot;New copy!&quot; &lt;&lt; endl;
					}
				}
			}
		}
		catch (const filesystem_error&amp; ex){
			cout &lt;&lt; ex.what() &lt;&lt; '\n';
		}
	}

	/*Code For copying directories recursively from StackOverflow Answer:
	 *http://stackoverflow.com/questions/8593608/how-can-i-copy-a-directory-using-boost-filesystem
	 *Courtesey of: nijansen
	 *Usage: copyDir(boost::filesystem::path(&quot;/home/nijansen/test&quot;), boost::filesystem::path(&quot;/home/nijansen/test_copy&quot;));
	 */

	bool copyDir(
		boost::filesystem::path const &amp; source,
		boost::filesystem::path const &amp; destination
	)
	{
		namespace fs = boost::filesystem;
		try
		{
			// Check whether the function call is valid
			if(
				!fs::exists(source) ||
				!fs::is_directory(source)
			)
			{
				std::cerr &lt;&lt; &quot;Source directory &quot; &lt;&lt; source.string()
					&lt;&lt; &quot; does not exist or is not a directory.&quot; &lt;&lt; '\n'
				;
				return false;
			}
			if(fs::exists(destination))
			{
				std::cerr &lt;&lt; &quot;Destination directory &quot; &lt;&lt; destination.string()
					&lt;&lt; &quot; already exists.&quot; &lt;&lt; '\n'
				;
				return false;
			}
			// Create the destination directory
			if(!fs::create_directory(destination))
			{
				std::cerr &lt;&lt; &quot;Unable to create destination directory&quot;
					&lt;&lt; destination.string() &lt;&lt; '\n'
				;
				return false;
			}
		}
		catch(fs::filesystem_error const &amp; e)
		{
			std::cerr &lt;&lt; e.what() &lt;&lt; '\n';
			return false;
		}
		// Iterate through the source directory
		for(
			fs::directory_iterator file(source);
			file != fs::directory_iterator(); ++file
		)
		{
			try
			{
				fs::path current(file-&gt;path());
				if(fs::is_directory(current))
				{
					// Found directory: Recursion
					if(
						!copyDir(
							current,
							destination / current.filename()
						)
					)
					{
						return false;
					}
				}
				else
				{
					// Found file: Copy
					fs::copy_file(
						current,
						destination / current.filename()
					);
				}
			}
			catch(fs::filesystem_error const &amp; e)
			{
				std:: cerr &lt;&lt; e.what() &lt;&lt; '\n';
			}
		}
		return true;
					</code>
				</pre>
			</div>
		</section>
		<section id="use">
			<h3><span class="fa fa-terminal" aria-hidden="true"></span> Usage and Compile Script </h3>
			<p>
				To use the program just plug in the backup devices and launch it.
				I made a simple shell script to compile and run the program for testing purposes.
				<em>This is <strong>definitely</strong> the incorrect way to do this</em> but it was a quick solution so I could
				get started on programming a prototype sooner.
				The C++ file is named boosteg.cpp and the program is called boostprog
			</p>
			<h4>Shell Script (compr.sh)</h4>
			sh compr.sh
			<div class="code">
				<pre class="prettyprint linenums">
					<code>
	g++ -o /home/kyle/Documents/c++-projects/boostprog /home/kyle/Documents/c++-projects/boosteg.cpp -lboost_filesystem -lboost_system;
	/home/kyle/Documents/c++-projects/boostprog
					</code>
				</pre>
			</div>
		</section>
		<section id="downloads">
			<h3><span class="fa fa-download" aria-hidden="true"></span> Downloads</h3>
			<ul>
				<li><a href="downloads/boosteg.cpp" target="_blank" title="opens new window">Source Code (boosteg.cpp)</a></li>
				<li><a href="downloads/boostprog" target="_blank" title="opens new window">Compiled Program [Ubuntu x64] (boostprog)</a></li>
				<li><a href="downloads/compr.sh" target="_blank" title="opens new window">Compile Script (compr.sh)</a></li>
				<li><a href="images/output.png" target="_blank" title="opens new window">Output Example Screenshot (output.png)</a></li>
			</ul>
		</section>
		<section id="description">
			<h3><span class="fa fa-info-circle" aria-hidden="true"></span> Description </h3>
			<p>
				This application is written in C++ and eventually once finished it will be cross platform. The source should be
				compilable on any platform which was my incentive for choosing the <a href="http://www.boost.org/" target="_blank" title="opens new window">
				Boost library</a> to manipulate the filesystem. The purpose of the application is to find the most recent
				directory or file that has been modified on the module root of one of 4 backup locations:
			</p>
			<ul>
				<li><abbr title="Universal Serial Bus">USB</abbr> Flash Drive</li>
				<li><abbr title="Secure Digital">SD</abbr> Card</li>
				<li>Laptop <abbr title="Hard Disk Drive">HDD</abbr></li>
				<li>University Network Storage</li>
			</ul>
			<p>
				Then the program will copy this directory or file to the other backup locations and append the date it was last
				modified to the name.
				At the moment the program only copies directories but files will be working in the near future.
			</p>
			<figure>
				<img src="images/output.png" height="119" width="307" alt="Screenshot of example directory" />
				<figcaption>
					Screenshot of file system showing a copied directory with the date appended to the file name
					This is an example of what the program would do if a folder called Workshop2 was edited on a
					backup device later than the folder on this device was edited. The original directory has been copied
					and the date has been appended to its name.
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
				<li><a href="#"><span class="fa fa-arrow-circle-up" aria-hidden="true"></span> Back to the top.</a></li>
				<li id="next-button"><a href="../project2/"><span class="fa fa-arrow-circle-right" aria-hidden="true"></span> Next project.</a></li>
			</ul>
		</nav>
	</footer>
</body>
</html>
