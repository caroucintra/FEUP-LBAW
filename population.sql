INSERT INTO authenticated_user (id, email, username, full_name, user_password, date_of_birth, isAdmin) VALUES
    (1,'joaopinto@mail.com','jaozinho','João Pinto','passdojoao','2001-05-18', False),
    (2,'joanapinto123@mail.com','itsmejoana','Joana Pinto','passdajoana','1995-08-20', False);

INSERT INTO user_follow (follower_id, followed_id) VALUES
    (1, 2),
    (2, 1);

INSERT INTO auction (id, auction_name, initial_price, deadline, item_description, auction_owner) VALUES
    (1,'Handpainted Jeans',45.00,'2021-12-19 10:23:54+02','I made this handpainted jeans a while back', 2);

INSERT INTO auction_follow (follower_id, auction_id) VALUES
    (1, 1);

INSERT INTO category (id, category_name) VALUES
    (1, 'Clothing'),
    (1, 'Painting');