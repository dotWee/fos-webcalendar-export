# fos-webcalendar-export

fos-webcalendar-export is a small script for exporting my school's web calendar to a CSV file. The main use is for easy an import and synchronization with Google Calendar as well as Microsoft Outlook.

Dependencies:

- PHP 5.6.14 =< installed
- A working connection to [fosbos.net](http://fosbos.net/)
- [Simple HTML DOM Parser](http://simplehtmldom.sourceforge.net/) (included)

## How to import / sync

- Download and install the latest PHP version
- Make sure the command **php** is accessible in your shell
- Get the archive of this project by clicking on the "Download ZIP" button 
- Unzip it somewhere and run the following command within the directory (This should work for Windows, Linux as well as Mac OS X):
        
        php -f calendar-export.php > calendar.csv

## License

Code licensed under the Apache 2.0 license. See [LICENSE.md](LICENSE.md) file for terms.
