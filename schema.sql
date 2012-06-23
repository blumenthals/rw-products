CREATE TABLE products (
    id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(256) NOT NULL,
    description TEXT,
    description2 TEXT,
    info VARCHAR(255),
    sku VARCHAR(64),
    price NUMERIC,
    weight NUMERIC,
    `group` VARCHAR(256) NOT NULL,
    image VARCHAR(256)
);

CREATE TABLE product_option_groups (
    id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    product_id BIGINT NOT NULL REFERENCES products(id),
    name VARCHAR(128) NOT NULL
);

CREATE TABLE product_options (
    name VARCHAR(128) NOT NULL PRIMARY KEY,
    product_group_id BIGINT NOT NULL REFERENCES product_option_groups(id),
    price NUMERIC
);

#CREATE UNIQUE INDEX product_option_groups_uniq ON product_option_groups (product_id, name);
