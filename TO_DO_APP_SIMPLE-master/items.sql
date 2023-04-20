
CREATE TABLE `items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(250)  NOT NULL,
  `create_time` bigint(20) COLLATE utf8mb4_unicode_ci NOT NULL ,
  CONSTRAINT fk_items FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE

)

ALTER TABLE `items`
  ADD KEY `title` (`title`);
COMMIT;


CREATE TABLE `users` (
`user_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
`name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
`email` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
`pass` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
`is_admin` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
