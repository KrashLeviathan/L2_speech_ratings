CREATE TABLE IF NOT EXISTS l2speechratings.Surveys (
  survey_id                INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name                     VARCHAR(64)      NOT NULL,
  description              VARCHAR(1024),
  start_date               DATETIME,
  end_date                 DATETIME,
  instructional_info       VARCHAR(8192),
  num_replays_allowed      INT(10)                   DEFAULT -1,
  total_time_limit         INT(10)                   DEFAULT -1,
  estimated_length_minutes INT(10)                   DEFAULT 60,
  closed                   TINYINT                   DEFAULT 0,
  notification_email       VARCHAR(64),
  target_rating_threshold  INT(10),
  notifications_enabled    TINYINT                   DEFAULT 0,

  PRIMARY KEY (survey_id)
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.Users (
  user_id         INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  google_id       VARCHAR(255)     NOT NULL UNIQUE KEY,
  first_name      VARCHAR(255)     NOT NULL,
  last_name       VARCHAR(255)     NOT NULL,
  email           VARCHAR(255)     NOT NULL,
  phone           VARCHAR(16),
  date_signed_up  DATETIME,
  payment_info_id INT(10),
  consent         TINYINT          NOT NULL DEFAULT '0',

  PRIMARY KEY (user_id)
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.SurveyCompletions (
  survey_completion_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  survey_id            INT(10) UNSIGNED NOT NULL,
  user_id              INT(10) UNSIGNED NOT NULL,
  date_completed       DATETIME         NOT NULL,

  PRIMARY KEY (survey_completion_id),

  CONSTRAINT fk_SurveyCompletions_1
  FOREIGN KEY (survey_id)
  REFERENCES l2speechratings.Surveys (survey_id)
    ON DELETE CASCADE,

  CONSTRAINT fk_SurveyCompletions_2
  FOREIGN KEY (user_id)
  REFERENCES l2speechratings.Users (user_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.Demographics (
  demographic_id           INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id                  INT(10) UNSIGNED NOT NULL,
  date_completed           DATETIME         NOT NULL,
  age                      INT(10) UNSIGNED,
  gender                   VARCHAR(16),
  birthplace               VARCHAR(255),
  location_raised          VARCHAR(255),
  native_languages         VARCHAR(255),
  education_level          VARCHAR(64),
  education_level_other    VARCHAR(255),
  sp_listening             INT(10),
  sp_speaking              INT(10),
  sp_reading               INT(10),
  sp_writing               INT(10),
  sp_age                   INT(10),
  sp_with_family           TINYINT,
  sp_usage_percent         INT(10),
  sp_nn_interaction        VARCHAR(64),
  sp_interaction_cap       VARCHAR(64),
  sp_interaction_cap_other VARCHAR(255),
  sp_nn_familiarity        INT(10),
  fr_listening             INT(10),
  fr_speaking              INT(10),
  fr_reading               INT(10),
  fr_writing               INT(10),
  fr_age                   INT(10),
  fr_with_family           TINYINT,
  fr_usage_percent         INT(10),
  fr_nn_interaction        VARCHAR(64),
  fr_interaction_cap       VARCHAR(64),
  fr_interaction_cap_other VARCHAR(255),
  fr_nn_familiarity        INT(10),
  en_listening             INT(10),
  en_speaking              INT(10),
  en_reading               INT(10),
  en_writing               INT(10),
  en_age                   INT(10),
  en_with_family           TINYINT,
  en_usage_percent         INT(10),
  instr_elementary         VARCHAR(64),
  instr_secondary          VARCHAR(64),
  instr_hs                 VARCHAR(64),
  instr_college            VARCHAR(64),
  instr_graduate           VARCHAR(64),
  addl_languages           VARCHAR(1024),
  ling_training            TINYINT,
  taught_language          TINYINT,
  personal_info            VARCHAR(1024),

  PRIMARY KEY (demographic_id),

  CONSTRAINT fk_Demographics_1
  FOREIGN KEY (user_id)
  REFERENCES l2speechratings.Users (user_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.PaymentInformation (
  payment_info_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id         INT(10) UNSIGNED NOT NULL,
  payment_info    VARCHAR(255),

  PRIMARY KEY (payment_info_id),

  CONSTRAINT fk_PaymentInformation_1
  FOREIGN KEY (user_id)
  REFERENCES l2speechratings.Users (user_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.AudioCategories (
  audio_category_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name              VARCHAR(64)      NOT NULL,
  description       VARCHAR(255),

  PRIMARY KEY (audio_category_id)
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.AudioSamples (
  audio_sample_id INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
  filename        VARCHAR(255) UNIQUE NOT NULL,
  size            INT(10)                      DEFAULT NULL,
  duration_ms     LONG                         DEFAULT NULL,
  type            VARCHAR(255)                 DEFAULT NULL,
  url             VARCHAR(255)                 DEFAULT NULL,
  upload_date     DATETIME                     DEFAULT NULL,
  language        VARCHAR(16)                  DEFAULT NULL,
  level           VARCHAR(8)                   DEFAULT NULL,
  speaker_id      INT(10)                      DEFAULT NULL,
  native_speaker  TINYINT                      DEFAULT NULL,
  wave            INT(10)                      DEFAULT NULL,
  task            INT(10)                      DEFAULT NULL,
  item            INT(10)                      DEFAULT NULL,
  error_tokens    VARCHAR(255)                 DEFAULT NULL,
  category_id     INT(10) UNSIGNED    NOT NULL DEFAULT '1',

  PRIMARY KEY (audio_sample_id),

  CONSTRAINT fk_AudioSamples_1
  FOREIGN KEY (category_id)
  REFERENCES l2speechratings.AudioCategories (audio_category_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.RatingProperties (
  rating_property_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name               VARCHAR(64)      NOT NULL,
  definition         VARCHAR(255),
  csv_value          VARCHAR(16)      NOT NULL,

  PRIMARY KEY (rating_property_id)
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.RatingScores (
  rating_score_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  score           INT(10)          NOT NULL,
  property        INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (rating_score_id),

  CONSTRAINT fk_RatingScores_1
  FOREIGN KEY (property)
  REFERENCES l2speechratings.RatingProperties (rating_property_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.RatingEvents (
  rating_event_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  date_time       DATETIME,
  performed_by_id INT(10) UNSIGNED NOT NULL,
  audio_sample_id INT(10) UNSIGNED NOT NULL,
  survey_id       INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (rating_event_id),

  CONSTRAINT fk_RatingEvents_1
  FOREIGN KEY (performed_by_id)
  REFERENCES l2speechratings.Users (user_id)
    ON DELETE CASCADE,

  CONSTRAINT fk_RatingEvents_2
  FOREIGN KEY (audio_sample_id)
  REFERENCES l2speechratings.AudioSamples (audio_sample_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.ControlFlags (
  control_flag_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id         INT(10) UNSIGNED NOT NULL,
  rating_event_id INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (control_flag_id),

  CONSTRAINT fk_ControlFlags_1
  FOREIGN KEY (user_id)
  REFERENCES l2speechratings.Users (user_id)
    ON DELETE CASCADE,

  CONSTRAINT fk_ControlFlags_2
  FOREIGN KEY (rating_event_id)
  REFERENCES l2speechratings.RatingEvents (rating_event_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;


CREATE TABLE IF NOT EXISTS l2speechratings.ControlRatings (
  control_rating_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  expected_score_id INT(10) UNSIGNED NOT NULL,
  audio_sample_id   INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (control_rating_id),

  CONSTRAINT fk_ControlRatings_1
  FOREIGN KEY (expected_score_id)
  REFERENCES l2speechratings.RatingScores (rating_score_id)
    ON DELETE CASCADE,

  CONSTRAINT fk_ControlRatings_2
  FOREIGN KEY (audio_sample_id)
  REFERENCES l2speechratings.AudioSamples (audio_sample_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.CorruptFiles (
  corrupt_file_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  reported_by     INT(10) UNSIGNED NOT NULL,
  date_reported   DATETIME,
  description     VARCHAR(1024),
  audio_sample_id INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (corrupt_file_id),

  CONSTRAINT fk_CorruptFiles_1
  FOREIGN KEY (reported_by)
  REFERENCES l2speechratings.Users (user_id)
    ON DELETE CASCADE,

  CONSTRAINT fk_CorruptFiles_2
  FOREIGN KEY (audio_sample_id)
  REFERENCES l2speechratings.AudioSamples (audio_sample_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.SampleBlocks (
  sample_block_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name            VARCHAR(64)      NOT NULL,
  date_created    DATETIME,

  PRIMARY KEY (sample_block_id)
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.SurveySampleBlockLookup (
  lookup_id       INT(10) UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  survey_id       INT(10) UNSIGNED        NOT NULL,
  sample_block_id INT(10) UNSIGNED        NOT NULL,

  PRIMARY KEY (survey_id, sample_block_id),

  CONSTRAINT fk_SurveySampleBlockLookup_1
  FOREIGN KEY (survey_id)
  REFERENCES l2speechratings.Surveys (survey_id)
    ON DELETE CASCADE,

  CONSTRAINT fk_SurveySampleBlockLookup_2
  FOREIGN KEY (sample_block_id)
  REFERENCES l2speechratings.SampleBlocks (sample_block_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.SampleBlockAudioLookup (
  lookup_id       INT(10) UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  sample_block_id INT(10) UNSIGNED        NOT NULL,
  audio_sample_id INT(10) UNSIGNED        NOT NULL,

  PRIMARY KEY (sample_block_id, audio_sample_id),

  CONSTRAINT fk_SampleBlockAudioLookup_1
  FOREIGN KEY (sample_block_id)
  REFERENCES l2speechratings.SampleBlocks (sample_block_id)
    ON DELETE CASCADE,

  CONSTRAINT fk_SampleBlockAudioLookup_2
  FOREIGN KEY (audio_sample_id)
  REFERENCES l2speechratings.AudioSamples (audio_sample_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.Invites (
  invite_id     INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  access_code   VARCHAR(255)     NOT NULL,
  email         VARCHAR(255)     NOT NULL,
  validation    VARCHAR(255),
  accepted_by   INT(10) UNSIGNED,
  accepted_date DATETIME,

  PRIMARY KEY (invite_id),
  CONSTRAINT fk_Invites_1
  FOREIGN KEY (accepted_by)
  REFERENCES l2speechratings.Users (user_id)
    ON DELETE SET NULL
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.Sessions (
  session_id   INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  date_created DATETIME,
  date_expires DATETIME,
  user_id      INT(10) UNSIGNED NOT NULL,

  PRIMARY KEY (session_id),

  CONSTRAINT fk_Sessions_1
  FOREIGN KEY (user_id)
  REFERENCES l2speechratings.Users (user_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.Admins (
  admin_id   INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id    INT(10) UNSIGNED NOT NULL,
  privileges VARCHAR(16)               DEFAULT 'NONE',

  PRIMARY KEY (admin_id),

  CONSTRAINT fk_Admins_1
  FOREIGN KEY (user_id)
  REFERENCES l2speechratings.Users (user_id)
    ON DELETE CASCADE
)
  DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS l2speechratings.RatingEventScoreLookup (
  lookup_id       INT(10) UNSIGNED UNIQUE NOT NULL AUTO_INCREMENT,
  rating_event_id INT(10) UNSIGNED        NOT NULL,
  rating_score_id INT(10) UNSIGNED        NOT NULL,

  PRIMARY KEY (rating_event_id, rating_score_id),

  CONSTRAINT fk_RatingEventScoreLookup_1
  FOREIGN KEY (rating_event_id)
  REFERENCES l2speechratings.RatingEvents (rating_event_id)
    ON DELETE CASCADE,

  CONSTRAINT fk_RatingEventScoreLookup_2
  FOREIGN KEY (rating_score_id)
  REFERENCES l2speechratings.RatingScores (rating_score_id)
    ON DELETE CASCADE
);

# Automatically set expiration date on sessions table before any attempted insert
DELIMITER $$

DROP TRIGGER IF EXISTS l2speechratings.tr_b_ins_sessions $$

CREATE TRIGGER l2speechratings.tr_b_ins_sessions
BEFORE INSERT ON l2speechratings.Sessions
FOR EACH ROW
  BEGIN
    SET NEW.date_expires = CURRENT_TIMESTAMP() + INTERVAL 7 DAY;
  END $$

DELIMITER ;
