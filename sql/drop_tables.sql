DELIMITER $$
DROP TRIGGER IF EXISTS L2_speech_ratings.tr_b_ins_sessions $$
DELIMITER ;

DROP TABLE IF EXISTS L2_speech_ratings.Admins;
DROP TABLE IF EXISTS L2_speech_ratings.Sessions;
DROP TABLE IF EXISTS L2_speech_ratings.Invites;
DROP TABLE IF EXISTS L2_speech_ratings.SampleBlockAudioLookup;
DROP TABLE IF EXISTS L2_speech_ratings.SurveySampleBlockLookup;
DROP TABLE IF EXISTS L2_speech_ratings.SampleBlocks;
DROP TABLE IF EXISTS L2_speech_ratings.Surveys;
DROP TABLE IF EXISTS L2_speech_ratings.CorruptFiles;
DROP TABLE IF EXISTS L2_speech_ratings.ControlRatings;
DROP TABLE IF EXISTS L2_speech_ratings.ControlFlags;
DROP TABLE IF EXISTS L2_speech_ratings.RatingEvents;
DROP TABLE IF EXISTS L2_speech_ratings.RatingScores;
DROP TABLE IF EXISTS L2_speech_ratings.RatingProperties;
DROP TABLE IF EXISTS L2_speech_ratings.AudioSamples;
DROP TABLE IF EXISTS L2_speech_ratings.AudioCategories;
DROP TABLE IF EXISTS L2_speech_ratings.PaymentInformation;
DROP TABLE IF EXISTS L2_speech_ratings.Demographics;
DROP TABLE IF EXISTS L2_speech_ratings.Users;
