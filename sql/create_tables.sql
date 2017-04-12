CREATE TABLE IF NOT EXISTS Listeners (
  listener_id     INT(10)      NOT NULL AUTO_INCREMENT,
  google_id       VARCHAR(255) NOT NULL UNIQUE KEY,
  first_name      VARCHAR(255) NOT NULL,
  last_name       VARCHAR(255) NOT NULL,
  email           VARCHAR(255) NOT NULL,
  phone           VARCHAR(16),
  date_signed_up  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  payment_info_id INT(10),
  university_id   VARCHAR(12),

  PRIMARY KEY (listener_id)
);

CREATE TABLE IF NOT EXISTS Demographics (
  demographic_id INT(10) NOT NULL AUTO_INCREMENT,
  listener_id    INT(10) NOT NULL,
  race           VARCHAR(64),
  etc            VARCHAR(255),

  PRIMARY KEY (demographic_id),

  CONSTRAINT demographic_listener_id_fk
  FOREIGN KEY (listener_id)
  REFERENCES Listeners (listener_id)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS PaymentInformation (
  payment_info_id INT(10) NOT NULL AUTO_INCREMENT,
  listener_id     INT(10) NOT NULL,
  payment_info    VARCHAR(255),

  PRIMARY KEY (payment_info_id),

  CONSTRAINT pi_listener_fk
  FOREIGN KEY (listener_id)
  REFERENCES Listeners (listener_id)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS AudioCategories (
  audio_category_id INT(10)     NOT NULL AUTO_INCREMENT,
  name              VARCHAR(64) NOT NULL,
  description       VARCHAR(255),

  PRIMARY KEY (audio_category_id)
);

CREATE TABLE IF NOT EXISTS AudioSamples (
  audio_sample_id INT(10)      NOT NULL AUTO_INCREMENT,
  duration_ms     LONG,
  filename        VARCHAR(255) NOT NULL,
  upload_date     DATETIME              DEFAULT CURRENT_TIMESTAMP(),
  category_id     INT(10)      NOT NULL,

  PRIMARY KEY (audio_sample_id),

  CONSTRAINT category_id_fk
  FOREIGN KEY (category_id)
  REFERENCES AudioCategories (audio_category_id)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS RatingProperties (
  rating_property_id INT(10)     NOT NULL AUTO_INCREMENT,
  name               VARCHAR(64) NOT NULL,
  definition         VARCHAR(255),

  PRIMARY KEY (rating_property_id)
);

CREATE TABLE IF NOT EXISTS RatingScores (
  rating_score_id INT(10) NOT NULL AUTO_INCREMENT,
  score           INT(10) NOT NULL,
  property        INT(10) NOT NULL,

  PRIMARY KEY (rating_score_id),

  CONSTRAINT rating_property_fk
  FOREIGN KEY (property)
  REFERENCES RatingProperties (rating_property_id)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS RatingEvents (
  rating_event_id INT(10) NOT NULL AUTO_INCREMENT,
  date_time       DATETIME         DEFAULT CURRENT_TIMESTAMP(),
  performed_by_id INT(10) NOT NULL,
  score_id        INT(10) NOT NULL,
  audio_sample_id INT(10) NOT NULL,

  PRIMARY KEY (rating_event_id),

  CONSTRAINT performed_by_fk
  FOREIGN KEY (performed_by_id)
  REFERENCES Listeners (listener_id)
    ON DELETE CASCADE,

  CONSTRAINT score_fk
  FOREIGN KEY (score_id)
  REFERENCES RatingScores (rating_score_id)
    ON DELETE CASCADE,

  CONSTRAINT audio_sample_fk
  FOREIGN KEY (audio_sample_id)
  REFERENCES AudioSamples (audio_sample_id)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ControlFlags (
  control_flag_id INT(10) NOT NULL AUTO_INCREMENT,
  listener_id     INT(10) NOT NULL,
  rating_event_id INT(10) NOT NULL,

  PRIMARY KEY (control_flag_id),

  CONSTRAINT control_flags_listener_id_fk
  FOREIGN KEY (listener_id)
  REFERENCES Listeners (listener_id)
    ON DELETE CASCADE,

  CONSTRAINT control_flags_rating_id_fk
  FOREIGN KEY (rating_event_id)
  REFERENCES RatingEvents (rating_event_id)
    ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS ControlRatings (
  control_rating_id INT(10) NOT NULL AUTO_INCREMENT,
  expected_score_id INT(10) NOT NULL,
  audio_sample_id   INT(10) NOT NULL,

  PRIMARY KEY (control_rating_id),

  CONSTRAINT expected_score_fk
  FOREIGN KEY (expected_score_id)
  REFERENCES RatingScores (rating_score_id)
    ON DELETE CASCADE,

  CONSTRAINT cr_audio_sample_fk
  FOREIGN KEY (audio_sample_id)
  REFERENCES AudioSamples (audio_sample_id)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS CorruptFiles (
  corrupt_file_id INT(10) NOT NULL AUTO_INCREMENT,
  reported_by     INT(10) NOT NULL,
  date_reported   DATETIME         DEFAULT CURRENT_TIMESTAMP(),
  description     VARCHAR(1024),
  audio_sample_id INT(10) NOT NULL,

  PRIMARY KEY (corrupt_file_id),

  CONSTRAINT reported_by_fk
  FOREIGN KEY (reported_by)
  REFERENCES Listeners (listener_id)
    ON DELETE CASCADE,

  CONSTRAINT corrupt_audio_fk
  FOREIGN KEY (audio_sample_id)
  REFERENCES AudioSamples (audio_sample_id)
    ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS Surveys (
  survey_id               INT(10)     NOT NULL AUTO_INCREMENT,
  name                    VARCHAR(64) NOT NULL,
  description             VARCHAR(1024),
  start_date              DATETIME             DEFAULT CURRENT_TIMESTAMP(),
  end_date                DATETIME,
  times_audio_plays       INT(10)              DEFAULT 0,
  instructional_info      VARCHAR(8192),
  notification_settings   VARCHAR(64),
  target_rating_threshold INT(10),

  PRIMARY KEY (survey_id)
);

CREATE TABLE IF NOT EXISTS SampleBlocks (
  sample_block_id INT(10)     NOT NULL AUTO_INCREMENT,
  name            VARCHAR(64) NOT NULL,
  date_created    DATETIME             DEFAULT CURRENT_TIMESTAMP(),

  PRIMARY KEY (sample_block_id)
);

CREATE TABLE IF NOT EXISTS SurveyBlocks (
  survey_block_id INT(10) NOT NULL AUTO_INCREMENT,
  survey_id       INT(10) NOT NULL,
  sample_block_id INT(10) NOT NULL,

  PRIMARY KEY (survey_block_id),

  CONSTRAINT survey_id_fk
  FOREIGN KEY (survey_id)
  REFERENCES Surveys (survey_id)
    ON DELETE CASCADE,

  CONSTRAINT sample_block_fk
  FOREIGN KEY (sample_block_id)
  REFERENCES SampleBlocks (sample_block_id)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS BlockAudioSamples (
  block_audio_id  INT(10) NOT NULL AUTO_INCREMENT,
  sample_block_id INT(10) NOT NULL,
  audio_sample_id INT(10) NOT NULL,

  PRIMARY KEY (block_audio_id),

  CONSTRAINT bas_sample_block_fk
  FOREIGN KEY (sample_block_id)
  REFERENCES SampleBlocks (sample_block_id)
    ON DELETE CASCADE,

  CONSTRAINT bas_audio_sample_fk
  FOREIGN KEY (audio_sample_id)
  REFERENCES AudioSamples (audio_sample_id)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Invites (
  invite_id   INT(10)      NOT NULL AUTO_INCREMENT,
  access_code VARCHAR(255) NOT NULL,
  email       VARCHAR(255) NOT NULL,
  validation  VARCHAR(255),

  PRIMARY KEY (invite_id)
);

CREATE TABLE IF NOT EXISTS Sessions (
  session_id   INT(10) NOT NULL AUTO_INCREMENT,
  date_created DATETIME         DEFAULT CURRENT_TIMESTAMP(),
  date_expires DATETIME,
  listener_id  INT(10) NOT NULL,

  PRIMARY KEY (session_id),

  CONSTRAINT sessions_listener_fk
  FOREIGN KEY (listener_id)
  REFERENCES Listeners (listener_id)
    ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS Admins (
  admin_id    INT(10) NOT NULL AUTO_INCREMENT,
  listener_id INT(10) NOT NULL,
  privileges  VARCHAR(16)      DEFAULT 'NONE',

  PRIMARY KEY (admin_id),

  CONSTRAINT admin_listener_fk
  FOREIGN KEY (listener_id)
  REFERENCES Listeners (listener_id)
    ON DELETE CASCADE
);

# Automatically set expiration date on sessions table before any attempted insert
DELIMITER $$

DROP TRIGGER IF EXISTS tr_b_ins_sessions $$

CREATE TRIGGER tr_b_ins_sessions
BEFORE INSERT ON Sessions
FOR EACH ROW
  BEGIN
    SET NEW.date_expires = CURRENT_TIMESTAMP() + INTERVAL 7 DAY;
  END $$

DELIMITER ;
