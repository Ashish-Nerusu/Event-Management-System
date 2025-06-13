CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);





CREATE TABLE managers (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);


CREATE TABLE events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(100) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    event_venue VARCHAR(100) NOT NULL,
    ticket_price DECIMAL(10, 2) NOT NULL,
    event_code VARCHAR(10) NOT NULL UNIQUE
);


CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    event_code VARCHAR(10) NOT NULL,
    num_tickets INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    booking_date DATE NOT NULL,
    FOREIGN KEY (event_code) REFERENCES events(event_code) ON DELETE CASCADE
);
