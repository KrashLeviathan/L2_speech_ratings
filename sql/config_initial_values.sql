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
