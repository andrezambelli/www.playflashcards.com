 -- drop SCHEMA if exists flashcarddb;
 -- CREATE SCHEMA `flashcarddb` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;

use flashcarddb;

-- drops
drop table if exists car_study_session;
drop table if exists car_card;
drop table if exists car_study;
drop table if exists car_deck;
drop table if exists car_user;
drop table if exists car_session;
drop table if exists car_cookie;
drop table if exists car_form;

-- create
create table car_user (
	user_id int not null auto_increment primary key comment 'Identificador do usuário',
    user_email varchar(255) not null comment 'Conta de e-mail do usuário',
    user_lang varchar(10) not null default 'en' comment 'Idioma do usuário',
    user_max_deck int not null default 5 comment 'Número máximo de grupos do usuário.',
    user_max_card int not null default 100 comment 'Número máximo de cartões por grupo.',
    user_max_study int not null default 500 comment 'Número máximo de estudos simultâneos por grupo.',
	user_update timestamp not null default current_timestamp comment 'Data da atualização do registro.',
	user_create timestamp not null default current_timestamp comment 'Data de criação do registro.'
) ENGINE InnoDB;

create table car_deck (
	deck_id int not null auto_increment primary key comment 'Identificador do grupo de flashcards',
    user_id int not null comment 'Identificador do usuário',
    deck_key varchar(12) not null comment 'Chave do grupo que será utilizada na URL',
	deck_name varchar(255) not null default 'Novo Grupo' comment 'Nome do grupo',
    deck_desc varchar(1024) comment 'Descrição do grupo.',
	deck_color  varchar(6) not null default '000000'comment 'Cor da fonte do cartão',
    deck_bgcolor varchar(6) not null default 'FFFFFF'comment 'Cor de fundo do cartão',
	deck_public tinyint not null default 0 comment 'Define se o grupo é púclico 1 ou privado 0',
    deck_nofollow tinyint not null default 0 comment 'O grupo pode ser público, mas ele não precisa ser indexado = 1',
	deck_update timestamp not null default current_timestamp comment 'Data da atualização do registro.',
	deck_create timestamp not null default current_timestamp comment 'Data de criação do registro.'
) ENGINE InnoDB;

create table car_card (
	card_id int not null auto_increment primary key comment 'Identificador do flashcard',
    user_id int not null comment 'Identificador do usuário',
    deck_id int not null comment 'Identificador do grupo de flashcards',
    card_key varchar(12) not null comment 'Chave do flashcard que será utilizada na URL',
	card_front varchar(255) comment 'Nome na frente do cartão cartão',
	card_back varchar(255) comment 'Nome atrás do cartão',
    card_true int not null default 0 comment 'Quantidade de respostas corretas.',
    card_false int not null default 0 comment 'Quantidade de respostas erradas.', 
    card_sequence int not null default 0 comment 'Quantidade de respostas certas em sequencia.', 
	card_update timestamp not null default current_timestamp comment 'Data da atualização do registro.',
	card_create timestamp not null default current_timestamp comment 'Data de criação do registro.'
) ENGINE InnoDB;

create table car_study (
	stud_id int not null auto_increment primary key comment 'Identificador do estudo',
    user_id int not null comment 'Identificador do usuário',
    deck_id int not null comment 'Identificador do grupo que será estudado',   
    stud_key varchar(12) not null comment 'Chave do estudo que será utilizada na URL',
    stud_total int not null default 0 comment 'Quantidade de falshcards dessa sessão de estudo',
    stud_true int not null default 0 comment 'Quantidade de cartões respondidos corretamente',
    stud_false int not null default 0 comment 'Quantidade de cartões respondidos erradamente', 
	stud_begin timestamp not null default current_timestamp comment 'Data da início da sessão de estudo',
	stud_end timestamp comment 'Data de fim da sessão de estudo',
	stud_public tinyint not null default 0 comment 'Define se o estudo foi respondio pelo púclico 1 ou privado 0',
	stud_update timestamp not null default current_timestamp comment 'Data da atualização do registro.',
	stud_create timestamp not null default current_timestamp comment 'Data de criação do registro.'
) ENGINE InnoDB;

create table car_study_session (
	stse_id int not null auto_increment primary key comment 'Identificador do estudo',
    stse_order int not null default 0 comment 'Ordem das perguntas',
    user_id int not null comment 'Identificador do usuário',
	stud_id int not null comment 'Identificador do estudo',
	card_id int not null comment 'Identificador do flashcard',
    stse_answer tinyint comment 'null = precisa responder; 1 = certo; 0 = errado'
) ENGINE InnoDB;

create table car_session ( 
  id varchar(32) NOT NULL COMMENT 'Stores the Session ID',
  access int unsigned NOT NULL,
  value text,
  created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

create table car_cookie (
	cook_id int not null auto_increment primary key comment 'Identificador do cookie (consentimento)',
    cook_key varchar(12) not null comment 'Chave de conscentimento que será gravada no cookie do usuario',
    user_id int not null default 0 comment 'Identificador do usuário (se for nulo, é navegação anônima)',
	cook_update timestamp not null default current_timestamp comment 'Data da atualização do registro.',
	cook_create timestamp not null default current_timestamp comment 'Data de criação do registro.'
) ENGINE InnoDB;

create table car_form (
	form_id int not null auto_increment primary key comment 'Identificador do comentário',
	form_type varchar(255) not null default 'Sem Tipo' comment 'Tipo do comentário',
	form_content varchar(2048) comment 'Conteúdo do comentário',
	form_create timestamp not null default current_timestamp comment 'Data de criação do registro.'
) ENGINE InnoDB;

-- alter
alter table car_user add constraint user_email_uk unique (user_email);

alter table car_deck add constraint deck_user_fk foreign key deck_user_fk (user_id) references car_user (user_id) on delete no action on update no action;
alter table car_card add constraint card_deck_fk foreign key card_deck_fk (deck_id) references car_deck (deck_id) on delete no action on update no action;
alter table car_card add constraint card_user_fk foreign key card_user_fk (user_id) references car_user (user_id) on delete no action on update no action;
alter table car_study add constraint stud_deck_fk foreign key stud_deck_fk (deck_id) references car_deck (deck_id) on delete no action on update no action;
alter table car_study add constraint stud_user_fk foreign key stud_user_fk (user_id) references car_user (user_id) on delete no action on update no action;
alter table car_study_session add constraint stse_user_fk foreign key stse_user_fk (user_id) references car_user (user_id) on delete no action on update no action;
alter table car_study_session add constraint stse_stud_fk foreign key stse_stud_fk (stud_id) references car_study (stud_id) on delete no action on update no action;
alter table car_study_session add constraint stse_card_fk foreign key stse_card_fk (card_id) references car_card (card_id) on delete no action on update no action;

alter table car_deck add unique index deck_key_ix (deck_key);
alter table car_card add unique index card_key_ix (card_key);
alter table car_study add unique index stud_key_ix (stud_key);
alter table car_session add unique index car_session_ix (id);

insert into car_user (user_email) values ('flashcardsplay@gmail.com');
