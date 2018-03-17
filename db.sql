SET @preparedStatement = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE  table_name = 'users'
        AND table_schema = DATABASE()
        AND column_name = 'email_company'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE `users` ADD `email_company` VARCHAR(255) NULL DEFAULT NULL;"
));

PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;



SET @preparedStatement = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE  table_name = 'orders'
        AND table_schema = DATABASE()
        AND column_name = 'order_phone'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE `orders` ADD `order_phone` VARCHAR(255) NULL DEFAULT NULL;"
));

PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;



SET @preparedStatement = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE  table_name = 'orders'
        AND table_schema = DATABASE()
        AND column_name = 'order_vat'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE `orders` ADD `order_vat` VARCHAR(255) NULL DEFAULT NULL;"
));

PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;



SET @preparedStatement = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE  table_name = 'orders'
        AND table_schema = DATABASE()
        AND column_name = 'order_name'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE `orders` ADD `order_name` VARCHAR(255) NULL DEFAULT NULL;"
));

PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;


SET @preparedStatement = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE  table_name = 'orders'
        AND table_schema = DATABASE()
        AND column_name = 'order_surname'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE `orders` ADD `order_surname` VARCHAR(255) NULL DEFAULT NULL;"
));

PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @preparedStatement = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE  table_name = 'orders'
        AND table_schema = DATABASE()
        AND column_name = 'delivery_address'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE `orders` ADD `delivery_address` VARCHAR(255) NULL DEFAULT NULL;"
));

PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

CREATE TABLE preview_last (id int);
INSERT INTO preview_last (id) VALUES (0);


SET @preparedStatement = (SELECT IF(
    (SELECT COUNT(*)
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE  table_name = 'order_row'
        AND table_schema = DATABASE()
        AND column_name = 'consignment'
    ) > 0,
    "SELECT 1",
    "ALTER TABLE `order_row` ADD `consignment` VARCHAR(255) NULL DEFAULT NULL;"
));

PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

ALTER TABLE `users`  ADD `language` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_general_ci
NOT NULL DEFAULT 'en'  AFTER `phone_company`;