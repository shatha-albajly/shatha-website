CREATE TABLE `users` (
  `id`  int(11) NOT NULL AUTO_INCREMENT ,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `role` varchar(15) NOT NULL DEFAULT 'client',
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (id)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
