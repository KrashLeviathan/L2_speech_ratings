# ESL Ratings Website

## Goal

The goal is to create a web application that facilitates Dr. Nagle’s
research on second language pronunciation development. It will feature
the ability for users to log in to the system with a
unique access code and rate a sampling of audio files on a scale of
1 to 9. The results can then be downloaded as a CSV file by the
administrator for use in language research.

## Development Notes

The following commands are for your local copy:

```
# Start the server
tools/serve.sh

# Re-initialize the database
tools/reinitialize_database.sh

# MySql server commands
/etc/init.d/mysql start
/etc/init.d/mysql stop
/etc/init.d/mysql restart
/etc/init.d/mysql status
```

### Dev Server

The dev server is `l2speechratings-dev.las.iastate.edu`. To access, you'll
need to VPN into `iastate.edu` first. The following commands/directories
are for the dev server:

```
# Apache server commands
systemctl start   httpd
systemctl stop    httpd
systemctl restart httpd
systemctl status  httpd

# Git repository clone is located at
/var/www/html/L2_speech_ratings

# Files are served from:
/opt/rh/httpd24/root/var/www/html/
# which contains symlinks to:
/var/www/html/config.txt
/var/www/html/l2speechratings

# Logs are stored at (???)
/var/log/httpd

# PHP logs (???)
/var/opt/rh/rh-php70/log/php-fpm/

# MySQL Client
mariadb
```

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
