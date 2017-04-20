#!/usr/bin/env bash

# Run from the root directory
pwd=`pwd`
folder=`basename $pwd`
if [ "$folder" != "L2_speech_ratings" ]; then
  echo "This script needs to be run from the root directory. Please navigate to that directory, and run:"
  echo "    tools/reinitialize_database.sh"
  exit 1;
fi

# Delete all audio files from the server
echo "[*] Delete all audio files from the server"
echo
rm -r "dist/files/upload_handler/files"
mkdir "dist/files/upload_handler/files"

# Reset database with initial values
echo "[*] Reset database with initial values"
echo
echo "Drop Tables"
mysql -u root -p < "sql/drop_tables.sql"
echo "Create Tables"
mysql -u root -p < "sql/create_tables.sql"
echo "Configure initial table values"
mysql -u root -p < "sql/config_initial_values.sql"

# This script is not tracked in git (populates user data
# for development, which includes Google ID and other PII)
echo "Configure additional development data (STOP AND REMOVE IF THIS IS A PRODUCTION BUILD!)"
mysql -u root -p < "sql/do_not_track.sql" # TODO: Should be removed after development is finished!

# For development, copy a few of the test files onto the server folder
echo
echo "[*] Copy test audio files to server folder"
echo
cp "test/sample_audios/3_w1_pic14.wav" "dist/files/upload_handler/files/3_w1_pic14.wav"
cp "test/sample_audios/3_w1_pic53.wav" "dist/files/upload_handler/files/3_w1_pic53.wav"
cp "test/sample_audios/3_w2_pic27.wav" "dist/files/upload_handler/files/3_w2_pic27.wav"

echo "[*] Done!"
