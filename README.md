# PHP-InfantMontior
This application is designed for the purpose of monitoring Infants which are being held in an incubator after birth and recording their physical statuses such as heart rate, breathing rate and humidity level. An external ardunio hardware measures the statuses and its interfacing software records the data to the database.
https://github.com/abel-tefera/PHP-InfantMontior.git

## Architecture
This app acts as the front end for the Infant monitoring system. Assuming data is inserted into the database from an external ardunio system, this app mainly draws *realtime graphs* as well as standard graphs by using the infant status data.

For the app to actually be usable at this point, it's necessary that another system periodically insert data, and I've included a C# console app to do exactly that. Of course, it's random data, but it does mimic the functions of the ardunio hardware and enables us to see the realtime graph in action. 

This app also includes authentication and authorization, for doctors, nurses and system admins. All of these users have different roles. Doctors are the ones able to view the graphs, and download the data in excel format, Nurses organize information about infants, such as assigning incubators and Admins control user accounts and such.  

## Directory structure
Inside ./app, you'll find the core logic of the application, written using custom PHP-MVC framework. 

Inside ./resources, I've included the console app which inserts random sample data, and the sql schema. Please read the readme file. 

The ./public directory mainly includes the google charts api, for drawing the graphs. 