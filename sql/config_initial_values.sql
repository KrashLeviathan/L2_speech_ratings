######### Set up the properties rated for each audio sample

INSERT INTO RatingProperties (rating_property_id, name, definition, csv_value)
VALUES (1, 'Comprehensibility', '', 'comprehension');
INSERT INTO RatingProperties (rating_property_id, name, definition, csv_value)
VALUES (2, 'Fluency', '', 'fluency');
INSERT INTO RatingProperties (rating_property_id, name, definition, csv_value)
VALUES (3, 'Accentedness', '', 'accent');

######### Default AudioCategory

INSERT INTO AudioCategories (`audio_category_id`, `name`, `description`)
VALUES (1, 'Uncategorized', 'Audio samples are assigned this category by default.');

######### Initial Invite

INSERT INTO Invites (`access_code`, `email`, `validation`)
VALUES ('INITIAL-INVITE', 'cnagle@iastate.edu', NULL);

######### Default Survey Information (until more sophisticated survey creation tools are implemented)

INSERT INTO Surveys (`survey_id`, `name`, `description`, `start_date`, `end_date`, `times_audio_plays`, `instructional_info`, `notification_settings`, `target_rating_threshold`)
VALUES ('1', 'Default', 'Contains all audio samples', NOW(), NULL, '-1', '', 'cnagle@iastate.edu', '10');

INSERT INTO SampleBlocks (`sample_block_id`, `name`)
VALUES ('1', 'Initial Block');

INSERT INTO SurveyBlocks (`survey_block_id`, `survey_id`, `sample_block_id`)
VALUES ('1', '1', '1');
