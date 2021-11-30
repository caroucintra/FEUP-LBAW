-----------------------------------------
-- Inserts
-----------------------------------------
INSERT INTO authenticated_user (id, email, username, full_name, user_password, date_of_birth, admin_permission) VALUES
    (1, 'joaopinto@mail.com', 'jaozinho', 'João Pinto', 'passdojoao', '2001-05-18', False),
    (2, 'joanapinto123@mail.com', 'itsmejoana', 'Joana Pinto', 'passdajoana', '1995-08-20', False),
    (3, 'josevicente@admin.com', 'admin1', 'José Vicente', 'admin123', '1985-05-06', True);

INSERT INTO authenticated_user (email, username, full_name, user_password, date_of_birth) VALUES
    ('luisarodrigues@mail.com', 'luisa', 'Luisa Rodrigues', 'passdaluisa', '2018-08-19'),
    ('carolcintra24@mail.com', 'carou', 'Carol Cintra', 'passdacarou', '2001-07-24'),
    ('luiscarv@admin.com', 'admin2', 'Luis Carvalho', 'admin123', '1998-01-25');

INSERT INTO user_follow (follower_id, followed_id) VALUES
    (1, 2),
    (2, 1),
    (4, 2),
    (1, 4);

INSERT INTO auction (id, auction_name, initial_price, deadline, item_description, auction_owner) VALUES
    (1,'Handpainted Jeans',45.00,'2021-12-19 10:23:54+02','I made this handpainted jeans a while back', 2);

INSERT INTO auction_follow (follower_id, auction_id) VALUES
    (1, 1);
	
INSERT INTO category (id, type, auction_id) VALUES
	(1, 'Clothing', 1),
	(2, 'Painting');

INSERT INTO bid (bid_value, auction_id, user_id) VALUES
    (50.00, 1, 1),
    (20.00, 1, 4);

INSERT INTO greatest_bid (bid_id, auction_id) VALUES
    (1, 1);

INSERT INTO user_comment (id, auction_id, comment_text, user_id) VALUES
    (1, 1, 'I love this painting job!',1);

INSERT INTO money_transaction (id, user_id, admin_id, transaction_value, type) VALUES
    (1, 1, 3, 35.00, 'Deposit'),
    (2, 4, 3, 50.00, 'Deposit');

INSERT INTO user_notification (id, user_id, type, follower_id) VALUES
    (1, 2, 'New Follower', 1);

INSERT INTO user_notification (id, user_id, type, comment_id) VALUES
    (2, 2, 'New Comment', 1);
	
INSERT INTO item_image (address, auction_id) VALUES
    ('xxx', 1);


--SELECT * FROM authenticated_user; 
--SELECT * FROM auction; 
--SELECT * FROM user_follow; 
--SELECT * FROM auction_follow; 
--SELECT * FROM category; 
--SELECT * FROM auction_category; 
--SELECT * FROM bid; 
--SELECT * FROM greatest_bid;
--SELECT * FROM user_comment;
--SELECT * FROM money_transaction; 
--SELECT * FROM user_notification;