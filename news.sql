-- Database for CNN Clone
CREATE DATABASE IF NOT EXISTS rslc7_rslc7_01;
USE rslc7_rslc7_01;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    content TEXT,
    is_featured BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Insert categories
INSERT INTO categories (name) VALUES ('World'), ('Politics'), ('Technology'), ('Sports'), ('Entertainment');

-- Insert articles (at least 10, 3 featured)
INSERT INTO articles (category_id, title, slug, image, content, is_featured) VALUES
(1, 'Global Summit on Climate Action Begins', 'global-summit-climate-begin', 'https://picsum.photos/1200/600?random=1', 'World leaders gather to discuss urgent climate goals and carbon footprint reduction strategies. The summit aims to reach a historic agreement.', 1),
(2, 'Upcoming Elections: What to Expect', 'upcoming-elections-expect', 'https://picsum.photos/1200/600?random=2', 'Political analysts weigh in on the shifting landscape as nations prepare for a year of decisive elections and potential policy changes.', 1),
(3, 'AI Breakthrough: The Future of Robotics', 'ai-breakthrough-future-robotics', 'https://picsum.photos/1200/600?random=3', 'Scientists announce a major leap in autonomous systems, allowing robots to learn complex tasks twice as fast as previous iterations.', 1),
(1, 'Space Mission Reaches Mars Orbit', 'space-mission-mars-orbit', 'https://picsum.photos/800/600?random=4', 'The latest probe has successfully entered the red planet orbit, ready to begin its three-year mission to study surface composition and history.', 0),
(4, 'Championship Finals: Live Updates', 'championship-finals-live-updates', 'https://picsum.photos/800/600?random=5', 'Follow all the action from the stadium as the final kicks off. Fans are electric and the stakes have never been higher for both teams.', 0),
(5, 'Hollywood Stars Gearing Up for Awards', 'hollywood-stars-awards-season', 'https://picsum.photos/800/600?random=6', 'The red carpet is ready for the biggest night in film. Anticipation is high as critics predict several surprise winners this year.', 0),
(3, 'New Quantum Computer Unveiled', 'new-quantum-computer-unveiled', 'https://picsum.photos/800/600?random=7', 'Tech giants reveal a machine that defies classical physics, promising processing speeds that could revolutionize medicine and security.', 0),
(2, 'Economic Policy Shift Sparks Debate', 'economic-policy-shift-debate', 'https://picsum.photos/800/600?random=8', 'Proposed tax reforms are meeting resistance in parliament as lawmakers argue over the impact on middle-class families and corporate growth.', 0),
(4, 'Rising Tennis Talent Wins Grand Slam', 'rising-tennis-talent-wins-grand-slam', 'https://picsum.photos/800/600?random=9', 'A 19-year-old phenom shocks the world with a flawless victory against the top seed, marking the beginning of a new era in professional tennis.', 0),
(1, 'Archaeologists Discover Ancient City', 'archaeologists-discover-ancient-city', 'https://picsum.photos/800/600?random=10', 'Remains of a 5,000-year-old civilization found in the desert, revealing intricate trade networks and advanced irrigation systems for the time.', 0);
