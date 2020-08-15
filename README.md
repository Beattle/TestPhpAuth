# TestPhpAuth

Скрипт простой авторизации

№ SQL

SELECT email
FROM  users
GROUP BY email
HAVING COUNT(*) > 1

SELECT u.login
FROM `orders`  o
RIGHT JOIN `users` u
ON o.user_id = u.id
WHERE `user_id` IS NULL

SELECT `login`
FROM `users` u
JOIN `orders` o
ON u.id = o.user_id
GROUP BY o.user_id
HAVING COUNT(*) > 2


