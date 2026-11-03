CREATE TABLE admin_scoped_sessions (
 id VARCHAR(64) PRIMARY KEY,
 token_hash CHAR(64) NOT NULL UNIQUE,
 expires_at DATETIME NOT NULL,
 revoked_at DATETIME NULL,
 created_at DATETIME NOT NULL
) ENGINE=InnoDB;