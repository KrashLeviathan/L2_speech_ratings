######### Set up the properties rated for each audio sample

INSERT INTO l2speechratings.RatingProperties (rating_property_id, name, definition, csv_value)
VALUES (1, 'Comprehensibility', '', 'comprehension');
INSERT INTO l2speechratings.RatingProperties (rating_property_id, name, definition, csv_value)
VALUES (2, 'Fluency', '', 'fluency');
INSERT INTO l2speechratings.RatingProperties (rating_property_id, name, definition, csv_value)
VALUES (3, 'Accentedness', '', 'accent');

######### Default AudioCategory

INSERT INTO l2speechratings.AudioCategories (`audio_category_id`, `name`, `description`)
VALUES (1, 'Uncategorized', 'Audio samples are assigned this category by default.');

######### Initial Invite

INSERT INTO l2speechratings.Invites (`access_code`, `email`, `validation`)
VALUES ('INITIAL-INVITE', 'cnagle@iastate.edu', NULL);

######### Default Survey Information (until more sophisticated survey creation tools are implemented)

INSERT INTO l2speechratings.Surveys (`survey_id`, `name`, `description`, `end_date`,
                                     `instructional_info`, `notification_email`, `target_rating_threshold`,
                                     `notifications_enabled`, `closed`)
VALUES
  ('1', 'Default', 'Contains all audio samples and survey defaults', NULL,
   '', 'cnagle@iastate.edu', '10',
   '0', '1');

INSERT INTO l2speechratings.SampleBlocks (`sample_block_id`, `name`)
VALUES ('1', 'Initial Block');

INSERT INTO l2speechratings.SurveySampleBlockLookup (`lookup_id`, `survey_id`, `sample_block_id`)
VALUES ('1', '1', '1');
