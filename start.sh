#!/bin/bash

MYSQL_DIR="$HOME/mysql_data"
MYSQL_SOCK="/tmp/mysql.sock"
MYSQL_PID="/tmp/mysql.pid"

# Initialize MariaDB data directory if not already done
if [ ! -d "$MYSQL_DIR" ]; then
  echo "Initializing MariaDB data directory..."
  mysql_install_db --datadir="$MYSQL_DIR" --auth-root-authentication-method=normal
fi

# Start MariaDB if not running
if ! mysqladmin --socket="$MYSQL_SOCK" ping --silent 2>/dev/null; then
  echo "Starting MariaDB..."
  mysqld_safe \
    --datadir="$MYSQL_DIR" \
    --socket="$MYSQL_SOCK" \
    --pid-file="$MYSQL_PID" \
    --port=3306 \
    --bind-address=127.0.0.1 \
    --log-error=/tmp/mysql_error.log \
    --skip-networking=0 \
    &

  # Wait for MySQL to start
  echo "Waiting for MariaDB to start..."
  for i in $(seq 1 30); do
    if mysqladmin --socket="$MYSQL_SOCK" ping --silent 2>/dev/null; then
      echo "MariaDB started successfully."
      break
    fi
    sleep 1
  done
fi

# Set up database and tables
echo "Setting up database..."
mysql --socket="$MYSQL_SOCK" -u root <<'SQL'
CREATE DATABASE IF NOT EXISTS user_db;
USE user_db;
CREATE TABLE IF NOT EXISTS `user_form` (
  `id` int(11) DEFAULT NULL,
  `name` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `user_type` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT IGNORE INTO `user_form` (`id`, `name`, `email`, `password`, `user_type`)
SELECT NULL, 'bkiay', '00022@student.wpu.ac.pg', 'd3e5895f2324afe58b86c34120166491', 'user'
WHERE NOT EXISTS (SELECT 1 FROM user_form WHERE email = '00022@student.wpu.ac.pg');

INSERT IGNORE INTO `user_form` (`id`, `name`, `email`, `password`, `user_type`)
SELECT NULL, 'Bethsheba Kiap', 'shebakiap@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'user'
WHERE NOT EXISTS (SELECT 1 FROM user_form WHERE email = 'shebakiap@gmail.com');

INSERT IGNORE INTO `user_form` (`id`, `name`, `email`, `password`, `user_type`)
SELECT NULL, 'Delilah', 'thelmatumbo@gmail.com', '5a8bf370052427008dda60f2fc06025b', 'user'
WHERE NOT EXISTS (SELECT 1 FROM user_form WHERE email = 'thelmatumbo@gmail.com');

CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `where_to` varchar(225) DEFAULT '',
  `guests` int(11) DEFAULT 1,
  `arrival_date` date DEFAULT NULL,
  `leaving_date` date DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` varchar(225) DEFAULT '',
  `email` varchar(225) NOT NULL,
  `phone` varchar(50) DEFAULT '',
  `country` varchar(100) DEFAULT '',
  `message` text NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL

echo "Database setup complete."

# Update PHP config to use socket
export MYSQL_SOCK="$MYSQL_SOCK"

# Start PHP built-in server on port 5000
echo "Starting PHP server on port 5000..."
exec php -S 0.0.0.0:5000 -t /home/runner/workspace
