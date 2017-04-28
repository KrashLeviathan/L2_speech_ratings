DELIMITER $$
DROP TRIGGER IF EXISTS l2speechratings.tr_b_ins_sessions $$
DELIMITER ;

DROP TABLE IF EXISTS l2speechratings.Admins;
DROP TABLE IF EXISTS l2speechratings.Sessions;
DROP TABLE IF EXISTS l2speechratings.Invites;
DROP TABLE IF EXISTS l2speechratings.SampleBlockAudioLookup;
DROP TABLE IF EXISTS l2speechratings.SurveySampleBlockLookup;
DROP TABLE IF EXISTS l2speechratings.SampleBlocks;
DROP TABLE IF EXISTS l2speechratings.CorruptFiles;
DROP TABLE IF EXISTS l2speechratings.ControlRatings;
DROP TABLE IF EXISTS l2speechratings.ControlFlags;
DROP TABLE IF EXISTS l2speechratings.SurveyCompletions;
DROP TABLE IF EXISTS l2speechratings.Surveys;
DROP TABLE IF EXISTS l2speechratings.RatingEventScoreLookup;
DROP TABLE IF EXISTS l2speechratings.RatingEvents;
DROP TABLE IF EXISTS l2speechratings.RatingScores;
DROP TABLE IF EXISTS l2speechratings.RatingProperties;
DROP TABLE IF EXISTS l2speechratings.AudioSamples;
DROP TABLE IF EXISTS l2speechratings.AudioCategories;
DROP TABLE IF EXISTS l2speechratings.PaymentInformation;
DROP TABLE IF EXISTS l2speechratings.Demographics;
DROP TABLE IF EXISTS l2speechratings.Users;
