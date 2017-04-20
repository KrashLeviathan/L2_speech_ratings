CREATE TABLE IF NOT EXISTS L2_speech_ratings.Users (
  user_id         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  google_id       VARCHAR(255)     NOT NULL UNIQUE KEY,
  first_name      VARCHAR(255)     NOT NULL,
  last_name       VARCHAR(255)     NOT NULL,
  email           VARCHAR(255)     NOT NULL,
  phone           VARCHAR(16),
  date_signed_up  DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  payment_info_id INT(10),
  university_id   VARCHAR(12),

  PRIMARY KEY (user_id)
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS L2_speech_ratings.Demographics (
  demographic_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id        INT(10) UNSIGNED NOT NULL,
  race           VARCHAR(64),
  etc            VARCHAR(255),

  PRIMARY KEY (demographic_id),

  CONSTRAINT fk_Demographics_1
  FOREIGN KEY (user_id)
  REFERENCES L2_speech_ratings.Users (user_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS L2_speech_ratings.PaymentInformation (
  payment_info_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id         INT(10) UNSIGNED NOT NULL,
  payment_info    VARCHAR(255),

  PRIMARY KEY (payment_info_id),

  CONSTRAINT fk_PaymentInformation_1
  FOREIGN KEY (user_id)
  REFERENCES L2_speech_ratings.Users (user_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS L2_speech_ratings.AudioCategories (
  audio_category_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name              VARCHAR(64)      NOT NULL,
  description       VARCHAR(255),

  PRIMARY KEY (audio_category_id)
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS L2_speech_ratings.AudioSamples (
  audio_sample_id INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
  filename        VARCHAR(255) UNIQUE NOT NULL,
  size            INT(10)                      DEFAULT NULL,
  duration_ms     LONG                         DEFAULT NULL,
  type            VARCHAR(255)                 DEFAULT NULL,
  url             VARCHAR(255)                 DEFAULT NULL,
  upload_date     DATETIME                     DEFAULT CURRENT_TIMESTAMP(),
  language        VARCHAR(16)                  DEFAULT NULL,
  level           VARCHAR(8)                   DEFAULT NULL,
  speaker_id      INT(10)                      DEFAULT NULL,
  wave            INT(10)                      DEFAULT NULL,
  task            INT(10)                      DEFAULT NULL,
  item            INT(10)                      DEFAULT NULL,
  error_tokens    VARCHAR(255)                 DEFAULT NULL,
  category_id     INT(10) UNSIGNED    NOT NULL DEFAULT '1',

  PRIMARY KEY (audio_sample_id),

  CONSTRAINT fk_AudioSamples_1
  FOREIGN KEY (category_id)
  REFERENCES L2_speech_ratings.AudioCategories (audio_category_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS L2_speech_ratings.RatingProperties (
  rating_property_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name               VARCHAR(64)      NOT NULL,
  definition         VARCHAR(255),
  csv_value          VARCHAR(16)      NOT NULL,

  PRIMARY KEY (rating_property_id)
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS L2_speech_ratings.RatingScores (
  rating_score_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  score           INT(10)          NOT NULL,
  property        INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (rating_score_id),

  CONSTRAINT fk_RatingScores_1
  FOREIGN KEY (property)
  REFERENCES L2_speech_ratings.RatingProperties (rating_property_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS L2_speech_ratings.RatingEvents (
  rating_event_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  date_time       DATETIME                  DEFAULT CURRENT_TIMESTAMP(),
  performed_by_id INT(10) UNSIGNED NOT NULL,
  score_id        INT(10) UNSIGNED NOT NULL,
  audio_sample_id INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (rating_event_id),

  CONSTRAINT fk_RatingEvents_1
  FOREIGN KEY (performed_by_id)
  REFERENCES L2_speech_ratings.Users (user_id)
    ON DELETE CASCADE,

  CONSTRAINT fk_RatingEvents_2
  FOREIGN KEY (score_id)
  REFERENCES L2_speech_ratings.RatingScores (rating_score_id)
    ON DELETE CASCADE,

  CONSTRAINT fk_RatingEvents_3
  FOREIGN KEY (audio_sample_id)
  REFERENCES L2_speech_ratings.AudioSamples (audio_sample_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS L2_speech_ratings.ControlFlags (
  control_flag_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id         INT(10) UNSIGNED NOT NULL,
  rating_event_id INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (control_flag_id),

  CONSTRAINT fk_ControlFlags_1
  FOREIGN KEY (user_id)
  REFERENCES L2_speech_ratings.Users (user_id)
    ON DELETE CASCADE,

  CONSTRAINT fk_ControlFlags_2
  FOREIGN KEY (rating_event_id)
  REFERENCES L2_speech_ratings.RatingEvents (rating_event_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;


CREATE TABLE IF NOT EXISTS L2_speech_ratings.ControlRatings (
  control_rating_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  expected_score_id INT(10) UNSIGNED NOT NULL,
  audio_sample_id   INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (control_rating_id),

  CONSTRAINT fk_ControlRatings_1
  FOREIGN KEY (expected_score_id)
  REFERENCES L2_speech_ratings.RatingScores (rating_score_id)
    ON DELETE CASCADE,

  CONSTRAINT fk_ControlRatings_2
  FOREIGN KEY (audio_sample_id)
  REFERENCES L2_speech_ratings.AudioSamples (audio_sample_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS L2_speech_ratings.CorruptFiles (
  corrupt_file_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  reported_by     INT(10) UNSIGNED NOT NULL,
  date_reported   DATETIME                  DEFAULT CURRENT_TIMESTAMP(),
  description     VARCHAR(1024),
  audio_sample_id INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (corrupt_file_id),

  CONSTRAINT fk_CorruptFiles_1
  FOREIGN KEY (reported_by)
  REFERENCES L2_speech_ratings.Users (user_id)
    ON DELETE CASCADE,

  CONSTRAINT fk_CorruptFiles_2
  FOREIGN KEY (audio_sample_id)
  REFERENCES L2_speech_ratings.AudioSamples (audio_sample_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;


CREATE TABLE IF NOT EXISTS L2_speech_ratings.Surveys (
  survey_id                INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name                     VARCHAR(64)      NOT NULL,
  description              VARCHAR(1024),
  start_date               DATETIME                  DEFAULT CURRENT_TIMESTAMP(),
  end_date                 DATETIME,
  instructional_info       VARCHAR(8192),
  num_replays_allowed      INT(10)                   DEFAULT -1,
  total_time_limit         INT(10)                   DEFAULT -1,
  estimated_length_minutes INT(10)                   DEFAULT 60,
  closed                   TINYINT                   DEFAULT 0,
  notification_settings    VARCHAR(64),
  target_rating_threshold  INT(10),

  PRIMARY KEY (survey_id)
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS L2_speech_ratings.SampleBlocks (
  sample_block_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name            VARCHAR(64)      NOT NULL,
  date_created    DATETIME                  DEFAULT CURRENT_TIMESTAMP(),

  PRIMARY KEY (sample_block_id)
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS L2_speech_ratings.SurveySampleBlockLookup (
  survey_block_id INT(10) UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  survey_id       INT(10) UNSIGNED        NOT NULL,
  sample_block_id INT(10) UNSIGNED        NOT NULL,

  PRIMARY KEY (survey_id, sample_block_id),

  CONSTRAINT fk_SurveySampleBlockLookup_1
  FOREIGN KEY (survey_id)
  REFERENCES L2_speech_ratings.Surveys (survey_id)
    ON DELETE CASCADE,

  CONSTRAINT fk_SurveySampleBlockLookup_2
  FOREIGN KEY (sample_block_id)
  REFERENCES L2_speech_ratings.SampleBlocks (sample_block_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS L2_speech_ratings.SampleBlockAudioLookup (
  block_audio_id  INT(10) UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  sample_block_id INT(10) UNSIGNED        NOT NULL,
  audio_sample_id INT(10) UNSIGNED        NOT NULL,

  PRIMARY KEY (sample_block_id, audio_sample_id),

  CONSTRAINT fk_SampleBlockAudioLookup_1
  FOREIGN KEY (sample_block_id)
  REFERENCES L2_speech_ratings.SampleBlocks (sample_block_id)
    ON DELETE CASCADE,

  CONSTRAINT fk_SampleBlockAudioLookup_2
  FOREIGN KEY (audio_sample_id)
  REFERENCES L2_speech_ratings.AudioSamples (audio_sample_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS L2_speech_ratings.Invites (
  invite_id     INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  access_code   VARCHAR(255)     NOT NULL,
  email         VARCHAR(255)     NOT NULL,
  validation    VARCHAR(255),
  accepted_by   INT(10) UNSIGNED,
  accepted_date DATETIME,

  PRIMARY KEY (invite_id),
  CONSTRAINT fk_Invites_1
  FOREIGN KEY (accepted_by)
  REFERENCES L2_speech_ratings.Users (user_id)
    ON DELETE SET NULL
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS L2_speech_ratings.Sessions (
  session_id   INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  date_created DATETIME                  DEFAULT CURRENT_TIMESTAMP(),
  date_expires DATETIME,
  user_id      INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (session_id),

  CONSTRAINT fk_Sessions_1
  FOREIGN KEY (user_id)
  REFERENCES L2_speech_ratings.Users (user_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS L2_speech_ratings.Admins (
  admin_id   INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id    INT(10) UNSIGNED NOT NULL,
  privileges VARCHAR(16)               DEFAULT 'NONE',

  PRIMARY KEY (admin_id),

  CONSTRAINT fk_Admins_1
  FOREIGN KEY (user_id)
  REFERENCES L2_speech_ratings.Users (user_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

# Automatically set expiration date on sessions table before any attempted insert
DELIMITER $$

DROP TRIGGER IF EXISTS L2_speech_ratings.tr_b_ins_sessions $$

CREATE TRIGGER L2_speech_ratings.tr_b_ins_sessions
BEFORE INSERT ON L2_speech_ratings.Sessions
FOR EACH ROW
  BEGIN
    SET NEW.date_expires = CURRENT_TIMESTAMP() + INTERVAL 7 DAY;
  END $$

DELIMITER ;
