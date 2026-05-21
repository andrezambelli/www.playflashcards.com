ALTER TABLE `flashcarddb`.`car_deck`
    ADD COLUMN `deck_url` VARCHAR(255) NOT NULL DEFAULT 'new-deck' AFTER `deck_desc`;
