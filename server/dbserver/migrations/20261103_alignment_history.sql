-- External MariaDB: future VIP state history, with no invented historical baseline.
CREATE TABLE IF NOT EXISTS vip_level_history (
 sequence BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id VARCHAR(191) NOT NULL, vip_level INT NOT NULL,
 recorded_at DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
 INDEX member_time (user_id, recorded_at, sequence)
) ENGINE=InnoDB;
DROP TRIGGER IF EXISTS bb_vip_history_insert;
CREATE TRIGGER bb_vip_history_insert AFTER INSERT ON users FOR EACH ROW
 INSERT INTO vip_level_history (user_id,vip_level) VALUES (NEW.id,NEW.vip_level);
DROP TRIGGER IF EXISTS bb_vip_history_update;
CREATE TRIGGER bb_vip_history_update AFTER UPDATE ON users FOR EACH ROW
 INSERT INTO vip_level_history (user_id,vip_level)
 SELECT NEW.id,NEW.vip_level WHERE NOT (OLD.vip_level <=> NEW.vip_level);
-- The installation baseline records only the actual current state, not previous days.
INSERT INTO vip_level_history (user_id,vip_level)
 SELECT u.id,u.vip_level FROM users u WHERE NOT EXISTS
 (SELECT 1 FROM vip_level_history h WHERE h.user_id=u.id);
CREATE TABLE IF NOT EXISTS wheel_ticket_days (
 user_id VARCHAR(191) PRIMARY KEY, ticket_day DATE NOT NULL
) ENGINE=InnoDB;
-- Existing undated free_spins are intentionally not assigned a fictitious grant day.