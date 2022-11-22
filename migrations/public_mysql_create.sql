CREATE TABLE IF NOT EXISTS `User` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`email` varchar(255) UNIQUE NOT NULL,
	`password` varchar(255) NOT NULL,
	`check_email` BOOLEAN NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `Privilege` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);
INSERT INTO `Privilege`(`id`, `name`)
VALUES ('1', 'creator'),
	   ('2', 'admin'),
	   ('3', 'user'),
	   ('4', 'guest')
	   ON DUPLICATE KEY UPDATE id=id;


CREATE TABLE IF NOT EXISTS `UserPrivilege` (
	`privilege_id` INT NOT NULL,
	`user_id` INT NOT NULL,
	`workspace_id` INT NOT NULL,
	CONSTRAINT `UserPrivilege_fk1` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`),
	CONSTRAINT `UserPrivilege_fk0` FOREIGN KEY (`privilege_id`) REFERENCES `Privilege`(`id`),
	CONSTRAINT `UserPrivilege_fk2` FOREIGN KEY (`workspace_id`) REFERENCES `Workspace`(`id`)
);

CREATE TABLE IF NOT EXISTS `Workspace` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`date_created` DATETIME NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `Desk` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`date_created` DATETIME NOT NULL,
	`workspace_id` INT NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `Desk_fk0` FOREIGN KEY (`workspace_id`) REFERENCES `Workspace`(`id`)
);

CREATE TABLE IF NOT EXISTS `Column` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`desk_id` INT NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `Column_fk0` FOREIGN KEY (`desk_id`) REFERENCES `Desk`(`id`)
);

CREATE TABLE IF NOT EXISTS `Card` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`description` TEXT NOT NULL,
	`date_created` DATETIME NOT NULL,
	`date_expiration` DATETIME NOT NULL,
	`is_done` BOOLEAN NOT NULL,
	`column_id` INT NOT NULL,
	`assigned` INT NOT NULL,
	`creator` INT NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `Card_fk0` FOREIGN KEY (`column_id`) REFERENCES `Column`(`id`),
	CONSTRAINT `Card_fk1` FOREIGN KEY (`assigned`) REFERENCES `User`(`id`),
	CONSTRAINT `Card_fk2` FOREIGN KEY (`creator`) REFERENCES `User`(`id`)

);

CREATE TABLE IF NOT EXISTS `Label` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	`color` INT NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `Attachment` (
	`id` INT NOT NULL AUTO_INCREMENT,
	`path` varchar(255) NOT NULL,
	`card_id` INT NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT `Attachment_fk0` FOREIGN KEY (`card_id`) REFERENCES `Card`(`id`)
);

CREATE TABLE IF NOT EXISTS `CardsLabel` (
	`card_id` INT NOT NULL,
	`label_id` INT NOT NULL,
	CONSTRAINT `CardsLabel_fk0` FOREIGN KEY (`card_id`) REFERENCES `Card`(`id`),
	CONSTRAINT `CardsLabel_fk1` FOREIGN KEY (`label_id`) REFERENCES `Label`(`id`)
);

-- ALTER TABLE `UserPrivilege` ADD CONSTRAINT `UserPrivilege_fk0` FOREIGN KEY (`privilege_id`) REFERENCES `Privilege`(`id`);

-- ALTER TABLE `UserPrivilege` ADD CONSTRAINT `UserPrivilege_fk1` FOREIGN KEY (`user_id`) REFERENCES `User`(`id`);

-- ALTER TABLE `UserPrivilege` ADD CONSTRAINT `UserPrivilege_fk2` FOREIGN KEY (`workspace_id`) REFERENCES `Workspace`(`id`);

-- ALTER TABLE `Desk` ADD CONSTRAINT `Desk_fk0` FOREIGN KEY (`workspace_id`) REFERENCES `Workspace`(`id`);

-- ALTER TABLE `Column` ADD CONSTRAINT `Column_fk0` FOREIGN KEY (`desk_id`) REFERENCES `Desk`(`id`);

-- ALTER TABLE `Card` ADD CONSTRAINT `Card_fk0` FOREIGN KEY (`column_id`) REFERENCES `Column`(`id`);

-- ALTER TABLE `Card` ADD CONSTRAINT `Card_fk1` FOREIGN KEY (`assigned`) REFERENCES `User`(`id`);

-- ALTER TABLE `Card` ADD CONSTRAINT `Card_fk2` FOREIGN KEY (`creator`) REFERENCES `User`(`id`);

-- ALTER TABLE `Attachment` ADD CONSTRAINT `Attachment_fk0` FOREIGN KEY (`card_id`) REFERENCES `Card`(`id`);

-- ALTER TABLE `CardsLabel` ADD CONSTRAINT `CardsLabel_fk0` FOREIGN KEY (`card_id`) REFERENCES `Card`(`id`);

-- ALTER TABLE `CardsLabel` ADD CONSTRAINT `CardsLabel_fk1` FOREIGN KEY (`label_id`) REFERENCES `Label`(`id`);











