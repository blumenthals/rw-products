CREATE TABLE products (
    id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(256) NOT NULL,
    description TEXT,
    description2 TEXT,
    info VARCHAR(255),
    sku VARCHAR(64),
    hidden TINYINT,
    price DECIMAL(10,2),
    weight DECIMAL(10,2),
    display ENUM('full-left', 'full-right', 'full-noimage', 'half-left', 'half-right', 'half-noimage', 'heading') DEFAULT 'full-right',
    badge ENUM('none', 'new', 'sale') DEFAULT 'none',
    sortOrder INTEGER,
    `group` VARCHAR(256) NOT NULL,
    image VARCHAR(256),
    thumbnail VARCHAR(256)
);

CREATE TABLE product_pages (
    product_id BIGINT NOT NULL REFERENCES products(id),
    page VARCHAR(256) NOT NULL
);

CREATE TABLE product_option_groups (
    id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT NOT NULL REFERENCES products(id),
    name VARCHAR(128) NOT NULL
);

CREATE TABLE product_options (
    id SERIAL PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    product_group_id BIGINT NOT NULL REFERENCES product_option_groups(id),
    price DECIMAL(10,2),
    UNIQUE KEY (name, product_group_id)
);

#CREATE UNIQUE INDEX product_option_groups_uniq ON product_option_groups (product_id, name);

CREATE TABLE product_settings (
    name VARCHAR(32) NOT NULL PRIMARY KEY,
    value TEXT NOT NULL
);
