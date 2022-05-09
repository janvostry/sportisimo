DROP TABLE IF EXISTS `brand`;

CREATE TABLE `brand` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `created` datetime NOT NULL,
    `modified` datetime NOT NULL,
    `name` varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE(`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DELIMITER //

CREATE TRIGGER `brand_insert`
    BEFORE INSERT ON `brand`
    FOR EACH ROW
    BEGIN
        SET NEW.`created` = NOW();
        SET NEW.`modified` = NOW();
    END//

CREATE TRIGGER `brand_update`
    BEFORE UPDATE ON `brand`
    FOR EACH ROW
    BEGIN
        SET NEW.`modified` = NOW();
    END//

DELIMITER ;
