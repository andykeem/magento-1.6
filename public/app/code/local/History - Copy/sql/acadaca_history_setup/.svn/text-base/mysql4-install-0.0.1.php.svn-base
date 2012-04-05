<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('history/product_attribute')};
CREATE TABLE IF NOT EXISTS {$this->getTable('history/product_attribute')}
(
    product_history_id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    product_id INT UNSIGNED NOT NULL,
    product_type_id VARCHAR(32) NOT NULL DEFAULT 'simple',
    product_sku VARCHAR(64) NOT NULL DEFAULT '',
    product_name VARCHAR(255) NOT NULL DEFAULT '',
    attribute_id INT UNSIGNED NOT NULL,
    attribute_code VARCHAR(255) NOT NULL DEFAULT '',
    attribute_label VARCHAR(255) NOT NULL DEFAULT '',
    previous_value VARCHAR(255) NOT NULL DEFAULT '',
    value VARCHAR(255) NOT NULL DEFAULT '',
    admin_user_id INT UNSIGNED NOT NULL,
    updated_at DATETIME NOT NULL,
    PRIMARY KEY (product_history_id),
    CONSTRAINT FK_PRODUCT_HISTORY_PRODUCT_ID FOREIGN KEY (product_id) REFERENCES {$this->getTable('catalog/product')} (entity_id),
    CONSTRAINT FK_PRODUCT_HISTORY_ADMIN_USER_ID FOREIGN KEY (admin_user_id) REFERENCES {$this->getTable('admin/user')} (user_id)

) ENGINE = InnoDB;

");

$installer->endSetup();