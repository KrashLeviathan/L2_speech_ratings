# ESL Ratings Website

## Goal

The goal is to create a web application that facilitates Dr. Nagle’s
research on second language pronunciation development. It will feature
the ability for users to log in to the system with a
unique access code and rate a sampling of audio files on a scale of
1 to 10. The results can then be downloaded as a CSV file by the
administrator for use in language research.

## Discussion

### User Information

The users will initially log in to the system using a unique access
code given to them by the administrator. This will allow them to
setup an account, which includes demographic information for use in
the language research. The account also tracks the user’s activity
within the system for use in compensation; however, no bank account
or otherwise sensitive personal information will be requested or
stored on the system. It simply associates the rating activity with
a name (and possible student ID), and compensation can be made through
other channels. __Again, there will be no functionality for paying the
user within the system__.

It might also be useful to give a simple feedback survey to users upon
completion. They could provide insight about the process for
improvement in the future.

### Audio File Upload, Management, and Sampling

The application will provide an interface for batch uploading of audio
files to the server. We can discuss file size and approximate number
of files to be uploaded (short term and long term), and from there we
will make sure to request enough server space to accommodate. It will
also provide some limited functionality for managing those files. We
can discuss the details later, but I’m assuming there should also be
a way to delete files and label subsets of files (e.g. all audio
samples by John Doe, or all samples from March 2017).

We can discuss how you would like to go about creating different blocks
of files for the users to rate. Maybe create a few different strategies
that you can switch between in the administrative settings. For example,
you could have files presented at random to the users, or maybe
present all samples from one subset chosen at random (e.g. all John
Doe’s samples, then all Jane Doe’s samples...), or maybe present samples
from John Doe in date chronological order.

### Other Administrative Features

The admin to the system will have access to an admin settings page
that the other users don’t have access to. It will feature some
or all of the following:

- Audio file management (upload, delete, etc)
- Downloading rating results as a CSV
- Access to user demographics and user statistics (also as CSV file)
- Survey adjustments (e.g. adjusting number of times audio can be played,
  updating the instructional information shown to users, etc.)
- Demographic information adjustments (in case you later discover you
  want to collect additional information from the users)
- Notification settings (emails upon target rating threshold reached)

## Deliverables

The Minimum Viable Product (MVP) will provide the following functionality:

- Upload audio files.
- User registration and demographic collection.
- Present the audio files to users, and collect ratings given by users.
- Download the audio file ratings and user demographics as a CSV document
  (plain-text document with comma-separated values)

The remaining features that have been discussed will be prioritized and
addressed as time permits. That way we can ensure you get a working
product in a timely manner, with more functionality added as incremental
improvements.

I will also plan on providing a short Retrospective Study after the
project is completed. This could help with future iterations of the
project as you use it next fall.

## Required from Client

The application will run on a LAMP web stack (Linux operating system,
Apache HTTP server, MySQL database, and PHP programming language). The
Client will need to provide the domain and hosting to deploy the final
product (including adequate server space to store the audio files).

The Client will also need to provide the demographic survey, some
sample files for testing/development, instructional information
displayed to the users, and any other written content that will need
to be in the application.

## Risks

### Malicious file uploads
None of the audio files will be executed on the server; basic file
upload restrictions and type-checking will prevent anything other than
audio files from being uploaded; only the administrator will have the
ability to upload files. 

### Corrupt audio file upload
Provide a mechanism for users to flag files that won’t play correctly.

### Compensation for little or no effort
Put quality assurance mechanisms in place to ensure participation and
flag inappropriate use (timers to ensure audio is listened to,
robot-prevention techniques, test ‘control’ data, etc.); low volume
of participants; screening of participants by Dr. Nagle.

### SQL injection attacks
Perform robust input validation and sanitization on all data fields,
on both client and server sides. 

### Unauthorized access to the system
Encryption of login information and other sensitive data; access code
expiration; low volume of participants; compensation not provided
through the system. 
	
## Timeline

- __29 March 2017__ - Project Proposal submitted
- __21 April 2017__ - Minimum Viable Product completed
- __28 April 2017__ - Retrospective Study delivered

## Other Thoughts

### Quality Assurance

Compare the length of time a user spends on a page to the length of
the given audio file. If the audio file is 20 seconds long but he’s
only there for 5, he’s not doing his job.

Put a simple mechanism in place to prevent someone from using a
robot (webdriver) to cheat the system. For example, a webdriver
could click play, wait 20 seconds, randomly click a rating, click
“Next”, and then repeat.

Put control data among the sample data given to a participant. The
last half of the audio snippet could be a clear voice saying “Give
this audio file a zero rating”. If it doesn’t get a zero, they’re
not doing their job.

I will leave it up to you to decide what to do with the quality
assurance information. The point is, we can track that stuff, and
you can weed out any lazy participants that might pollute the test
data.

## Development Notes

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
