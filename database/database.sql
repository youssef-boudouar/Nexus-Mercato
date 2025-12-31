CREATE TABLE players(
	id INT PRIMARY KEY AUTO_INCREMENT,
	name VARCHAR(50),
	nationality VARCHAR(50),
	position ENUM('Attacker', 'Defender', 'Center', 'GoalKeeper'),
    market_value DECIMAL(12,2)
);

CREATE TABLE coaches(
	id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50),
	nationality VARCHAR(50)
);

CREATE TABLE teams(
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    budget DECIMAL(14, 2),
    manager VARCHAR(100)
);

CREATE TABLE contracts(
    id INT PRIMARY KEY AUTO_INCREMENT,
    player_id INT,
    coach_id INT,
    team_id INT,
    salary DECIMAL(10,2),
    start_date DATE,
    end_date DATE,
    FOREIGN KEY (player_id) REFERENCES players(id),
    FOREIGN KEY (coach_id) REFERENCES coaches(id),
    FOREIGN KEY (team_id) REFERENCES teams(id)
);

CREATE TABLE transfers(
    id INT PRIMARY KEY AUTO_INCREMENT,
    player_id INT,
    departure_team_id INT,
    arrival_team_id INT,
    transfer_status ENUM('in progress', 'done'),
    amount DECIMAL (12,2),
    FOREIGN KEY (player_id) REFERENCES players(id) ON DELETE CASCADE,
    FOREIGN KEY (departure_team_id) REFERENCES teams(id) ON DELETE CASCADE,
    FOREIGN KEY (arrival_team_id) REFERENCES teams(id) ON DELETE CASCADE
);
