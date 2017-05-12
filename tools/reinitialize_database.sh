#!/usr/bin/env bash

# Run from the root directory
pwd=`pwd`
folder=`basename $pwd`
if [ "$folder" != "L2_speech_ratings" ]; then
  echo "This script needs to be run from the root directory. Please navigate to that directory, and run:"
  echo "    tools/reinitialize_database.sh"
  exit 1;
fi

# Delete all storage files from the server
echo "[*] Deleting all storage files (results, demographics, audio_samples) from the server"
echo
rm -r "dist/file_storage"
mkdir "dist/file_storage"
mkdir "dist/file_storage/results"
mkdir "dist/file_storage/demographics"
mkdir "dist/file_storage/audio_samples"
mkdir "dist/file_storage/survey_completions"

# Reset database with initial values
echo "[*] Resetting database with initial values"
echo
echo "Dropping Tables"
mysql -u root -p < "sql/drop_tables.sql"
echo "Creating Tables"
mysql -u root -p < "sql/create_tables.sql"
echo "Configuring initial table values"
mysql -u root -p < "sql/config_initial_values.sql"

# This script is not tracked in git (populates user data
# for development, which includes Google ID and other PII)
#echo "Configuring additional development data (STOP AND REMOVE IF THIS IS A PRODUCTION BUILD!)"
#mysql -u root -p < "sql/do_not_track.sql"

# For development, copy a few of the test files onto the server folder
#echo
#echo "[*] Copying test audio files to file_storage folder (STOP AND REMOVE IF THIS IS A PRODUCTION BUILD!)"
#echo
#cp "test/sample_audios/3_w1_pic14.wav" "dist/file_storage/audio_samples/3_w1_pic14.wav"
#cp "test/sample_audios/3_w1_pic53.wav" "dist/file_storage/audio_samples/3_w1_pic53.wav"
#cp "test/sample_audios/3_w2_pic27.wav" "dist/file_storage/audio_samples/3_w2_pic27.wav"

echo "[*] Done!"
