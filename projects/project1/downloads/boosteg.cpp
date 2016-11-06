//  filesystem tut3.cpp  ---------------------------------------------------------------//

//  Copyright Beman Dawes 2009

//  Distributed under the Boost Software License, Version 1.0.
//  See http://www.boost.org/LICENSE_1_0.txt

//  Library home page: http://www.boost.org/libs/filesystem

#include <iostream>
#include <iterator>
#include <algorithm>
#include <boost/filesystem.hpp>
using namespace std;
using namespace boost::filesystem;
bool copyDir(boost::filesystem::path const & source,
 boost::filesystem::path const & destination);
void backUpEdited(path workPath, path altPath);

int main()
{
	path kyleMediaPath ("/media/kyle");
	path stcMediaPath ("/media/stc905");
	path workingMediaPath;
	path webLaptopSoftPath ("/home/kyle/Documents/Software_Eng/Web_Dev");
	path progLaptopSoftPath ("/home/kyle/Documents/Software_Eng/Programming");
	path dbsLaptopSoftPath ("/home/kyle/Documents/Software_Eng/Databases");
	const string UBTDEV = "/UBUNTU 16_0";
	const string WINDEV = "/J_CCSA_X64FRE_EN-US_DV5";
	const string PROG = "/Software Eng/Programming";
	const string WEB = "/Software Eng/Web Dev";
	const string DBS = "/Software Eng/Databases";
	path testpath ("/media/kyle/UBUNTU 16_0/Software Eng/Programming/testfold");
	path testpath1 ("/media/kyle/J_CCSA_X64FRE_EN-US_DV5/Software Eng/Programming/testfold");
	cout << copyDir(testpath,testpath1) << endl;
	try{
		if(exists(kyleMediaPath)){
			workingMediaPath = kyleMediaPath;
			cout << "Kyle Media Path" << endl;
		}else if(exists(stcMediaPath)){
			workingMediaPath = stcMediaPath;
			cout << "STC Media Path" << endl;
		}else{
			cout << "No recognisable /media/ path exiting" << endl;
			return 1;
		}
		directory_iterator end_itr;
		vector<string> dirs;
		for (directory_iterator itr(workingMediaPath); itr != end_itr; itr++){
			string pathToString = itr->path().string();
			path workingDevPath;
			path altDevPath;
			if(pathToString == workingMediaPath.string()+ UBTDEV){
				workingDevPath = path(workingMediaPath.string() + UBTDEV);
				altDevPath = path(workingMediaPath.string() + WINDEV);
			}else if(pathToString == workingMediaPath.string() +WINDEV){
				altDevPath = path(workingMediaPath.string() + UBTDEV);
				workingDevPath = path(workingMediaPath.string() + WINDEV);
			}else{
				cout << "No media inserted, exiting" << endl;
				return 1;
			}
			cout << "Working path is: " + workingDevPath.string() << endl; 
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
	catch (const filesystem_error& ex){
		cout << ex.what() << '\n';
	}
	return 0;
}

void backUpEdited(path workPath, path altPath){
	try{
		directory_iterator end_itr;
		for(directory_iterator itr(altPath); itr != end_itr; itr++){
			if(is_directory(itr->path())){
				string endOfPath = itr->path().string().substr(altPath.string().length());
				cout << "End of Path: " << endl;;
				cout << endOfPath << endl;
				path dupPath (workPath.string()+endOfPath);
				cout << "Dup Path: " << endl;
				cout << dupPath.string() << endl;
				if(exists(dupPath)){
					if(last_write_time(dupPath) != last_write_time(itr->path())){
						cout << "Last Mod Dup"; cout << last_write_time(dupPath) << endl;
						time_t now = time(0);
						cout << ctime(&now) << endl;
						path newPath (dupPath.string() + "_" + ctime(&now));
						cout << copyDir(itr->path(),newPath) << endl;
					}
				}else{
					copyDir(itr->path(),dupPath);
					cout << "New copy!" << endl;
				}
			}
		}
	}
	catch (const filesystem_error& ex){
		cout << ex.what() << '\n';
	}
}

/*Code For copying directories recursively from StackOverflow Answer:
 *http://stackoverflow.com/questions/8593608/how-can-i-copy-a-directory-using-boost-filesystem
 *Courtesey of: nijansen
 *Usage: copyDir(boost::filesystem::path("/home/nijansen/test"), boost::filesystem::path("/home/nijansen/test_copy"));
 */

bool copyDir(
    boost::filesystem::path const & source,
    boost::filesystem::path const & destination
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
            std::cerr << "Source directory " << source.string()
                << " does not exist or is not a directory." << '\n'
            ;
            return false;
        }
        if(fs::exists(destination))
        {
            std::cerr << "Destination directory " << destination.string()
                << " already exists." << '\n'
            ;
            return false;
        }
        // Create the destination directory
        if(!fs::create_directory(destination))
        {
            std::cerr << "Unable to create destination directory"
                << destination.string() << '\n'
            ;
            return false;
        }
    }
    catch(fs::filesystem_error const & e)
    {
        std::cerr << e.what() << '\n';
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
            fs::path current(file->path());
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
        catch(fs::filesystem_error const & e)
        {
            std:: cerr << e.what() << '\n';
        }
    }
    return true;
}
