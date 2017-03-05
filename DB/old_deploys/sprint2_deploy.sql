use paws_db;
ALTER TABLE cats MODIFY COLUMN breed VARCHAR(75) NOT NULL;
ALTER TABLE cats ADD color VARCHAR(75) NOT NULL;
ALTER TABLE cats ADD coat VARCHAR(75) NOT NULL;
ALTER TABLE cats MODIFY COLUMN specialty_notes TEXT;
ALTER TABLE cats DROP COLUMN caretaker_notes; 
ALTER TABLE cats DROP COLUMN microchiped_date;
ALTER TABLE cats ADD diet TEXT;
ALTER TABLE cats ADD is_microchip_registered BOOLEAN;