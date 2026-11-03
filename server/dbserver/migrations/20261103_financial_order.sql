-- Transactional per-member ordering, shared by all PHP settlement writers.
-- Historical NULL order is unknown and is never reconstructed from timestamps.
CREATE TABLE financial_clocks (
  user_id VARCHAR(64) NOT NULL PRIMARY KEY,
  seq BIGINT UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB;
ALTER TABLE transactions ADD COLUMN financial_seq BIGINT UNSIGNED NULL,
  ADD UNIQUE KEY member_transaction_seq (user_id, financial_seq),
  ADD INDEX member_transaction_order (user_id, type, status, financial_seq);
ALTER TABLE bets ADD COLUMN financial_seq BIGINT UNSIGNED NULL,
  ADD UNIQUE KEY member_bet_seq (user_id, financial_seq);

DELIMITER $$
CREATE TRIGGER financial_transaction_insert BEFORE INSERT ON transactions FOR EACH ROW
BEGIN
  SET NEW.financial_seq = NULL;
  IF (NEW.type IN ('deposit','bonus') AND NEW.status='success') OR NEW.type='withdraw' THEN
    INSERT IGNORE INTO financial_clocks (user_id,seq) VALUES (NEW.user_id,0);
    UPDATE financial_clocks SET seq=seq+1 WHERE user_id=NEW.user_id;
    SET NEW.financial_seq=(SELECT seq FROM financial_clocks WHERE user_id=NEW.user_id);
  END IF;
END$$
CREATE TRIGGER financial_transaction_update BEFORE UPDATE ON transactions FOR EACH ROW
BEGIN
  SET NEW.financial_seq=OLD.financial_seq;
  IF OLD.type='deposit' AND OLD.status='pending' AND NEW.status='success' THEN
    INSERT IGNORE INTO financial_clocks (user_id,seq) VALUES (NEW.user_id,0);
    UPDATE financial_clocks SET seq=seq+1 WHERE user_id=NEW.user_id;
    SET NEW.financial_seq=(SELECT seq FROM financial_clocks WHERE user_id=NEW.user_id);
  END IF;
END$$
CREATE TRIGGER financial_bet_insert BEFORE INSERT ON bets FOR EACH ROW
BEGIN
  INSERT IGNORE INTO financial_clocks (user_id,seq) VALUES (NEW.user_id,0);
  UPDATE financial_clocks SET seq=seq+1 WHERE user_id=NEW.user_id;
  SET NEW.financial_seq=(SELECT seq FROM financial_clocks WHERE user_id=NEW.user_id);
END$$
DELIMITER ;