
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- product_replaced_by
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `product_replaced_by`;

CREATE TABLE `product_replaced_by`
(
    `product_id` INTEGER NOT NULL,
    `replaced_by_id` INTEGER NOT NULL,
    PRIMARY KEY (`product_id`),
    INDEX `FI_product_replaced_by_replaced_by_id` (`replaced_by_id`),
    CONSTRAINT `fk_product_replaced_by_product_id`
        FOREIGN KEY (`product_id`)
        REFERENCES `product` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE,
    CONSTRAINT `fk_product_replaced_by_replaced_by_id`
        FOREIGN KEY (`replaced_by_id`)
        REFERENCES `product` (`id`)
        ON UPDATE RESTRICT
        ON DELETE CASCADE
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
