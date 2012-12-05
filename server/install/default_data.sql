USE jewelry;

-- root user
INSERT INTO `user` (name, password, type, create_time) 
            VALUES ('root', md5('root'), 'SuperAdmin', NOW()) 
                ON DUPLICATE KEY UPDATE name=name;

-- default types
INSERT INTO `product_type` 
    (name) 
    VALUES 
    ('女戒'), ('男戒'), ('对戒'), ('吊坠'), ('耳坠'), ('手镯/手链')
        ON DUPLICATE KEY UPDATE name=name;

INSERT INTO `product_brand` 
    (name) 
    VALUES 
    ('卡地亚'), ('蒂芙妮'), ('钻之韵')
        ON DUPLICATE KEY UPDATE name=name;

-- default settings
INSERT INTO `setting` 
    (`key`, `value`) 
    VALUES 
    ('labor_expense', '15'),
    ('wear_tear', '14'),
    ('st_expense', '20'),
    ('st_price', '2300'),
    ('weight_ratio', '1.2'),
    ('risk_expense', '25')
        ON DUPLICATE KEY UPDATE `key`=`key`;
