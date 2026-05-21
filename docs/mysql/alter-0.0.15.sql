ALTER TABLE `flashcarddb`.`car_deck` 
CHANGE COLUMN `deck_nofollow` `deck_follow` TINYINT NOT NULL DEFAULT '0' COMMENT 'O grupo pode ser público, mas ele não precisa ser indexado = 0' ;

ALTER TABLE `flashcarddb`.`car_user`
    ADD COLUMN `user_last_access` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `user_max_study`;

update car_deck set deck_follow = 0 where deck_id > 0;