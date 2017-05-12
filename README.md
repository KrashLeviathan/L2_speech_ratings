# ESL Ratings Website

## Goal

The goal is to create a web application that facilitates Dr. Nagle’s
research on second language pronunciation development. It will feature
the ability for users to log in to the system with a
unique access code and rate a sampling of audio files on a scale of
1 to 9. The results can then be downloaded as a CSV file by the
administrator for use in language research.

## Development Notes

### Dev Server

`l2speechratings-dev.las.iastate.edu`

### Start the PHP Server:

`cd dist; php7.0 -S localhost:8000`

### To start MySql server:

`/etc/init.d/mysql start`

### To stop MySql server:

`/etc/init.d/mysql stop`

### To restart MySql server:

`/etc/init.d/mysql restart`

### To check the status of  MySql server:

`/etc/init.d/mysql status`

## Deployment

1. VPN into the ISU network
2. SSH into the server
3. Become superuser to make changes: `sudo su`
4. `cd /var/www/html/L2_speech_ratings` (this is just code from the repo -- it's
   not served)
5. Pull changes: `git pull`
6. Remove previously-served files: `cd ..; rm -r l2speechratings/*`
7. Copy the dist folder to the serve location: `cd l2speechratings; cp -r ../L2_speech_ratings/dist/* .`
8. Open `l2speechratings/_includes/config.php` and comment/uncomment the
   appropriate lines (at the top and bottom)
9. If config.txt has been changed:
   - `cd /var/www/html; cp L2_speech_ratings/config.txt .` (NOTE: This file
     is actually pointed to by a symbolic link at /opt/rh/httpd24/root/var/www/html)
10. If php.ini has been changed:
    - Copy the `php.ini` file into the appropriate location
    - Restart the PHP server
