ALTER TABLE `flashcarddb`.`car_card` ADD COLUMN `card_rate` INT NOT NULL DEFAULT '0' AFTER `card_false`;

ALTER TABLE `flashcarddb`.`car_card`
    ADD COLUMN `card_last_study` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `card_sequence`;

ALTER TABLE `flashcarddb`.`car_user`
    CHANGE COLUMN `user_last_access` `user_last_access` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Último acesso do usuário' ;

ALTER TABLE `flashcarddb`.`car_user`
    ADD COLUMN `user_srs_limit` INT NOT NULL DEFAULT 20 COMMENT 'Número máximo de cartões por estudo para SRS.' AFTER `user_max_study`;

ALTER TABLE `flashcarddb`.`car_user`
    ADD COLUMN `user_srs_rate` INT NOT NULL DEFAULT 75 AFTER `user_srs_limit`;

ALTER TABLE `flashcarddb`.`car_user`
    CHANGE COLUMN `user_srs_rate` `user_srs_rate` INT NOT NULL DEFAULT '75' COMMENT 'Cartões com uma taxa de acerto abaixo de X porcento terão prioridade para estudo.' ;

ALTER TABLE `flashcarddb`.`car_user`
    ADD COLUMN `user_srs_sequence` INT NOT NULL DEFAULT 5 COMMENT 'Cartões que não foram respondidos corretamente nas últimas X sessões de estudo podem ser incluídos na sessão de estudo.' AFTER `user_srs_rate`;

ALTER TABLE `flashcarddb`.`car_user`
    ADD COLUMN `user_srs_days` INT NOT NULL DEFAULT 7 COMMENT 'Cartões que não foram estudados por mais de X dias serão reintroduzidos como opções de estudo.' AFTER `user_srs_sequence`;

ALTER TABLE `flashcarddb`.`car_card`
    CHANGE COLUMN `card_rate` `card_rate` INT NOT NULL DEFAULT '0' COMMENT 'Taxa de assertividade desde cartão. Utilizada no SRS.' ;

ALTER TABLE `flashcarddb`.`car_card`
    CHANGE COLUMN `card_last_study` `card_last_study` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Data de último estudo desse cartão.' ;
