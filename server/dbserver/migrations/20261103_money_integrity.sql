-- Database-level last line of defence for money and one-time claims.
ALTER TABLE daily_signin_records ADD UNIQUE KEY member_signin_date (user_id,date);
ALTER TABLE promo_redemptions ADD UNIQUE KEY member_promo_once (promo_id,user_id);
ALTER TABLE rescue_claims ADD UNIQUE KEY member_rescue_date (user_id,date);
ALTER TABLE users ADD CONSTRAINT chk_users_balance_nonneg CHECK (balance >= 0);
