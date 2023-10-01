USE recipes;

CREATE TABLE units (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255) NOT NULL,
    created DATETIME,
    modified DATETIME
);

CREATE TABLE recipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created DATETIME,
    modified DATETIME
);

CREATE TABLE ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description VARCHAR(255) NOT NULL,
    amount INT NOT NULL,
    unit VARCHAR(255),
    recipe_id INT NOT NULL,
    created DATETIME,
    modified DATETIME,
    FOREIGN KEY recipe_key (recipe_id) REFERENCES recipes(id)
); 

INSERT INTO units (description, created, modified)
VALUES
('g', NOW(), NOW());

INSERT INTO units (description, created, modified)
VALUES
('ml', NOW(), NOW());

INSERT INTO recipes (title, description, created, modified)
VALUES
('Chocolate cake', 'Bake it at 200°C for 40 minutes. This is an example recipe for our hiring test - Om Nom Nom', NOW(), NOW());

INSERT INTO ingredients (description, amount, unit, recipe_id, created, modified)
VALUES
('sugar', 100, 'g', 1, NOW(), NOW());

INSERT INTO ingredients (description, amount, unit, recipe_id, created, modified)
VALUES
('flour', 50, 'g', 1, NOW(), NOW());

INSERT INTO ingredients (description, amount, unit, recipe_id, created, modified)
VALUES
('eggs', 2, '', 1, NOW(), NOW());

INSERT INTO ingredients (description, amount, unit, recipe_id, created, modified)
VALUES
('chocolate', 150, 'g', 1, NOW(), NOW());

INSERT INTO ingredients (description, amount, unit, recipe_id, created, modified)
VALUES
('milk', 50, 'ml', 1, NOW(), NOW());