######### Set up the properties rated for each audio sample

INSERT INTO L2_speech_ratings.RatingProperties (rating_property_id, name, definition, csv_value)
VALUES (1, 'Comprehensibility', '', 'comprehension');
INSERT INTO L2_speech_ratings.RatingProperties (rating_property_id, name, definition, csv_value)
VALUES (2, 'Fluency', '', 'fluency');
INSERT INTO L2_speech_ratings.RatingProperties (rating_property_id, name, definition, csv_value)
VALUES (3, 'Accentedness', '', 'accent');

######### Default AudioCategory

INSERT INTO L2_speech_ratings.AudioCategories (`audio_category_id`, `name`, `description`)
VALUES (1, 'Uncategorized', 'Audio samples are assigned this category by default.');

######### Initial Invite

INSERT INTO L2_speech_ratings.Invites (`access_code`, `email`, `validation`)
VALUES ('INITIAL-INVITE', 'cnagle@iastate.edu', NULL);

######### Default Survey Information (until more sophisticated survey creation tools are implemented)

INSERT INTO L2_speech_ratings.Surveys (`survey_id`, `name`, `description`, `end_date`, `instructional_info`, `notification_settings`, `target_rating_threshold`)
VALUES ('1', 'Default', 'Contains all audio samples', NULL, '', 'cnagle@iastate.edu', '10');

INSERT INTO L2_speech_ratings.SampleBlocks (`sample_block_id`, `name`)
VALUES ('1', 'Initial Block');

INSERT INTO L2_speech_ratings.SurveySampleBlockLookup (`survey_block_id`, `survey_id`, `sample_block_id`)
VALUES ('1', '1', '1');
