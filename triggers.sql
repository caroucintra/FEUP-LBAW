-----------------------------------------
-- Triggers
-----------------------------------------

DROP FUNCTION IF EXISTS valid_bid();
CREATE FUNCTION valid_bid() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF (SELECT credit 
        FROM authenticated_user
        WHERE NEW.user_id = id) < NEW.bid_value THEN
    RAISE EXCEPTION 'The bidder does not have enough money in the account.';
    END IF;
    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER valid_bid
        BEFORE INSERT OR UPDATE ON bid
        FOR EACH ROW
        EXECUTE PROCEDURE valid_bid();

----------------------------------

DROP FUNCTION IF EXISTS greatest_bid_update();
CREATE FUNCTION greatest_bid_update() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF (EXISTS (SELECT * 
              FROM greatest_bid
              WHERE NEW.auction_id = auction_id)) THEN
    UPDATE greatest_bid
    SET bid_id = NEW.bid_id
    WHERE auction_id = NEW.auction_id;
	ELSE
    INSERT INTO greatest_bid(bid_id, auction_id) VALUES
        (NEW.id, NEW.auction_id);
    END IF;
    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER greatest_bid_update
        AFTER INSERT ON bid
        FOR EACH ROW
        EXECUTE PROCEDURE greatest_bid_update();

----------------------------------

DROP FUNCTION IF EXISTS valid_bid_value();
CREATE FUNCTION valid_bid_value() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF NEW.bid_value <= (SELECT initial_price
                        FROM auction
                        WHERE NEW.auction_id = id)
    OR NEW.bid_value <= (SELECT bid_value
                        FROM bid
                        WHERE id = (SELECT bid_id
                                    FROM greatest_bid 
                                    WHERE auction_id = NEW.auction_id))
    THEN RAISE EXCEPTION 'The new bid needs to be greater than the current greatest bid.';
    END IF;
    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER valid_bid_value
        BEFORE INSERT OR UPDATE ON bid
        FOR EACH ROW
        EXECUTE PROCEDURE valid_bid_value();

----------------------------------

DROP FUNCTION IF EXISTS follow_after_action();
CREATE FUNCTION follow_after_action() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF NOT EXISTS (SELECT *
                  FROM auction_follow
                  WHERE auction_id = NEW.auction_id AND NEW.user_id = user_id)
    THEN INSERT INTO auction_follow(follower_id, auction_id) VALUES
        (NEW.user_id, NEW.auction_id);
    END IF;
    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER follow_after_comment
        AFTER INSERT OR UPDATE ON user_comment
        FOR EACH ROW
        EXECUTE PROCEDURE follow_after_action();


CREATE TRIGGER follow_after_bid
        BEFORE INSERT OR UPDATE ON bid
        FOR EACH ROW
        EXECUTE PROCEDURE follow_after_action();

----------------------------------

DROP FUNCTION IF EXISTS verify_admin();
CREATE FUNCTION verify_admin() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF (NEW.type = 'Deposit' OR NEW.type = 'Debit')
    AND NOT(SELECT admin_permission
          FROM authenticated_user
          WHERE id = NEW.admin_id) THEN
    RAISE EXCEPTION 'The transaction is not valid because there is no approval from a verified admin';
    
    END IF;
    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verify_admin
        BEFORE INSERT OR UPDATE ON money_transaction
        FOR EACH ROW
        EXECUTE PROCEDURE verify_admin();

----------------------------------

DROP FUNCTION IF EXISTS notify_new_comment();
CREATE FUNCTION notify_new_comment() RETURNS TRIGGER AS
$BODY$
DECLARE
    f auction_follow%rowtype;
BEGIN

    FOR f IN (SELECT follower_id
             FROM auction_follow
             WHERE auction_id = NEW.auction_id)
    LOOP INSERT INTO user_notification(user_id, type, comment_id) VALUES
        (f.follower_id, 'New Comment', NEW.id);
		END LOOP;

    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notify_new_comment
        AFTER INSERT OR UPDATE ON user_comment
        FOR EACH ROW
        EXECUTE PROCEDURE notify_new_comment();

----------------------------------

