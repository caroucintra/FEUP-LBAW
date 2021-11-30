

BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

-- Insert auction
INSERT INTO auction (auction_name, initial_price, deadline, item_description, auction_owner)
 VALUES ($auction_name, $initial_price, $deadline, $item_description, $auction_owner;

-- Insert category
INSERT INTO category (auction_id)
 VALUES (currval('auction_id_seq'));

END TRANSACTION;