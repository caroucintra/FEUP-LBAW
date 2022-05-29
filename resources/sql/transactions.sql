SET search_path TO lbaw2184;
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

-- Insert auction
INSERT INTO auction (name, initial_price, deadline, description, auction_owner)
 VALUES ($name, $initial_price, $deadline, $description, $auction_owner;

-- Insert category
INSERT INTO category (auction_id)
 VALUES (currval('auction_id_seq'));

END TRANSACTION;
