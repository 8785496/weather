CREATE TABLE `temp` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `city` VARCHAR(16),
    `temp` FLOAT,
    `date` INT
) DEFAULT CHARACTER SET utf8 ENGINE=InnoDB;


INSERT INTO `temp`
(`city`, `temp`, `date`) VALUES
("nsk", 10.1, 111111);