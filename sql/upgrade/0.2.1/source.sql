CREATE TABLE IF NOT EXISTS source (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  update_timestamp VARCHAR(45) NOT NULL ,
  create_timestamp VARCHAR(45) NOT NULL ,
  name VARCHAR(45) NOT NULL ,
  PRIMARY KEY (id) ,
  UNIQUE INDEX uq_name (name ASC) )
ENGINE = InnoDB;
INSERT IGNORE INTO source ( name ) VALUES ( 'statscan' ), ( 'ministry' ), ( 'rdd' );
