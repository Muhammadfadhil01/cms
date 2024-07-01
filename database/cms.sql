-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Jul 2024 pada 17.38
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(99) NOT NULL,
  `cat_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(72, 'Tech'),
(73, 'Finance');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_post_id` int(11) NOT NULL,
  `comment_author` varchar(255) NOT NULL,
  `comment_email` varchar(255) NOT NULL,
  `comment_content` text NOT NULL,
  `comment_status` varchar(255) NOT NULL,
  `comment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `comments`
--

INSERT INTO `comments` (`comment_id`, `comment_post_id`, `comment_author`, `comment_email`, `comment_content`, `comment_status`, `comment_date`) VALUES
(95, 166, 'fadhil900', 'example@gmail.com', 'that\'s good!', 'Approve', '2024-07-01'),
(100, 166, 'fadhil900', 'example@gmail.com', 'awesome!\r\n', 'Unapprove', '2024-07-01'),
(101, 167, 'fadhil900', 'example@gmail.com', 'good!', 'Approve', '2024-07-01'),
(102, 167, 'fadhil900', 'example@gmail.com', 'awesome!\r\n', 'Approve', '2024-07-01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `liked_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `post_category_id` int(11) NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_author` varchar(255) NOT NULL,
  `post_date` date NOT NULL,
  `post_image` text NOT NULL,
  `post_content` text NOT NULL,
  `post_tags` varchar(255) NOT NULL,
  `post_comment_count` int(255) NOT NULL,
  `post_status` varchar(255) NOT NULL DEFAULT 'draft',
  `post_view_count` int(11) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `posts`
--

INSERT INTO `posts` (`post_id`, `post_category_id`, `post_title`, `post_author`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_comment_count`, `post_status`, `post_view_count`, `likes`) VALUES
(166, 72, 'What is PHP?', 'fadhil900', '2024-07-01', 'Desain tanpa judul.png', '<h3>What is PHP?</h3><p>PHP, which stands for \"PHP: Hypertext Preprocessor,\" is a widely-used open-source scripting language. It is especially suited for web development and can be embedded into HTML.</p><p><br></p><h4>Key Features of PHP</h4><ol><li><p><strong>Open Source</strong>: PHP is free to use, distribute, and modify, making it accessible to a large number of developers.</p></li><li><p><strong>Server-Side Scripting</strong>: PHP scripts are executed on the server, which means the client receives the output of the script without seeing the underlying code. This helps in maintaining security and reducing the amount of data transferred.</p></li><li><p><strong>Embedded in HTML</strong>: PHP code can be embedded directly within HTML code, allowing for dynamic content generation. This makes it easy to mix PHP with other languages like HTML, CSS, and JavaScript.</p></li><li><p><strong>Cross-Platform</strong>: PHP runs on various platforms, including Windows, Linux, macOS, and Unix. It is compatible with most web servers such as Apache, Nginx, and IIS.</p></li><li><p><strong>Extensive Database Support</strong>: PHP supports a wide range of databases, including MySQL, PostgreSQL, SQLite, and MongoDB. This versatility makes it a popular choice for developing database-driven applications.</p></li></ol><h4>Benefits of Using PHP</h4><ol><li><p><strong>Easy to Learn</strong>: PHP has a relatively simple syntax, making it easier for beginners to learn and start developing web applications.</p></li><li><p><strong>Large Community</strong>: Being one of the oldest scripting languages, PHP has a large and active community. This means a wealth of resources, tutorials, and support are available online.</p></li><li><p><strong>Frameworks and Tools</strong>: There are many powerful frameworks and tools built with PHP, such as Laravel, Symfony, and CodeIgniter, which streamline and enhance the development process.</p></li><li><p><strong>Scalability</strong>: PHP applications can easily be scaled to accommodate growing user bases. Many high-traffic websites, including Facebook and Wikipedia, use PHP for their backend.</p><p><br></p></li></ol><h4>Common Uses of PHP</h4><ol><li><p><strong>Web Pages and Web Applications</strong>: PHP is commonly used to create dynamic web pages and web applications, allowing for user interactions and database integration.</p></li><li><p><strong>Content Management Systems (CMS)</strong>: Popular CMS platforms like WordPress, Joomla, and Drupal are built with PHP, making it easy to manage and create content-rich websites.</p></li><li><p><strong>E-commerce Applications</strong>: PHP powers many e-commerce platforms, such as Magento and WooCommerce, providing robust solutions for online stores.</p></li><li><p><strong>Web Services</strong>: PHP can be used to create RESTful and SOAP web services, facilitating data exchange between different systems and applications.</p></li></ol><h4><br></h4><h4>Conclusion</h4><p>PHP remains a powerful and versatile scripting language for web development. Its ease of use, extensive support, and robust features make it an excellent choice for both beginners and experienced developers. Whether you\'re building a simple website or a complex web application, PHP provides the tools and flexibility needed to bring your projects to life.</p>', 'PHP, PROGRAMMING, TECH', 6, 'published', 20, 0),
(167, 72, 'What is JavaScript?', 'fadhil900', '2024-07-01', 'Desain tanpa judul (1).png', '<h3>What is JavaScript?</h3><p>JavaScript is a versatile, high-level programming language primarily known for its role in web development. It enables developers to create interactive and dynamic web pages by adding behavior to the HTML and CSS elements. JavaScript is a core technology of the World Wide Web, alongside HTML and CSS, and is supported by all modern web browsers without the need for additional plugins.</p><p><br></p><h4>Key Features of JavaScript</h4><ol><li><p><strong>Dynamic Typing</strong>: JavaScript is dynamically typed, meaning variables can hold values of any data type and their type can change at runtime. This provides flexibility in coding but also requires careful handling to avoid type-related errors.</p></li><li><p><strong>First-Class Functions</strong>: Functions in JavaScript are first-class citizens, which means they can be assigned to variables, passed as arguments to other functions, and returned from functions. This feature supports functional programming and higher-order functions.</p></li><li><p><strong>Prototypal Inheritance</strong>: JavaScript uses prototypal inheritance rather than classical inheritance found in languages like Java or C++. This means objects can inherit properties and methods directly from other objects.</p></li><li><p><strong>Event-Driven</strong>: JavaScript is often used to handle events such as user interactions (clicks, hovers, inputs) on web pages. It provides an event-driven architecture, allowing developers to define what should happen when specific events occur.</p></li><li><p><strong>Asynchronous Programming</strong>: JavaScript supports asynchronous programming, primarily through callbacks, promises, and async/await syntax. This is crucial for handling tasks like network requests, where waiting for responses without blocking the main thread is essential.</p></li><li><p><strong>Client-Side and Server-Side</strong>: While traditionally used as a client-side scripting language, JavaScript can also be used on the server side with environments like Node.js. This allows for the development of entire applications using a single language.</p></li><li><p><strong>Cross-Platform</strong>: JavaScript can run on various platforms and devices, including desktops, mobile devices, and servers. Its cross-platform nature makes it a versatile choice for developers.</p><p><br></p></li></ol><h4>Benefits of Using JavaScript</h4><ol><li><p><strong>Interactivity</strong>: JavaScript enables the creation of highly interactive and responsive web pages. It can update the content dynamically, validate forms, create animations, and more, providing a rich user experience.</p></li><li><p><strong>Rich Ecosystem</strong>: JavaScript has a vast ecosystem of libraries and frameworks, such as React, Angular, Vue.js, and jQuery, which streamline development processes and offer pre-built solutions for common tasks.</p></li><li><p><strong>Community Support</strong>: JavaScript has a large, active community of developers who contribute to its continuous improvement. This community support ensures a wealth of resources, tutorials, and tools available for developers.</p></li><li><p><strong>Full-Stack Development</strong>: With the advent of Node.js, JavaScript can be used for both front-end and back-end development. This allows developers to work on the entire application stack using a single language, improving consistency and productivity.</p></li><li><p><strong>Real-Time Applications</strong>: JavaScript is well-suited for building real-time applications such as chat applications, gaming, and collaborative tools due to its asynchronous capabilities and support for WebSockets.</p><p><br></p></li></ol><h4>Common Uses of JavaScript</h4><ol><li><p><strong>Web Development</strong>: JavaScript is the backbone of modern web development, enabling the creation of interactive and dynamic websites. It is used extensively for front-end development, enhancing user interfaces and experiences.</p></li><li><p><strong>Server-Side Development</strong>: With Node.js, JavaScript is used for server-side scripting, handling requests, managing databases, and building scalable back-end services.</p></li><li><p><strong>Mobile App Development</strong>: JavaScript frameworks like React Native and Ionic enable the development of cross-platform mobile applications using a single codebase, reducing development time and effort.</p></li><li><p><strong>Game Development</strong>: JavaScript is used in game development, especially for web-based games. Libraries like Phaser and Three.js facilitate the creation of 2D and 3D games.</p></li><li><p><strong>Desktop Applications</strong>: Frameworks like Electron allow developers to build cross-platform desktop applications using JavaScript, HTML, and CSS, making it possible to create powerful and feature-rich applications.</p><p><br></p></li></ol><h4>Conclusion</h4><p>JavaScript is an essential technology for web development, offering a wide range of features that enable developers to create interactive, dynamic, and user-friendly web applications. Its versatility extends beyond the browser, making it a valuable language for server-side development, mobile app development, game development, and more. With its robust ecosystem, community support, and continuous evolution, JavaScript remains a critical tool for modern developers looking to build sophisticated applications across various platforms.</p>', 'JAVASCRIPT, PROGRAMMING, TECH', 2, 'published', 5, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_image` text NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `user_password`, `user_firstname`, `user_lastname`, `user_email`, `user_image`, `user_role`, `token`) VALUES
(84, 'fadhil900', '$2y$10$9yOCyes1k0qXH8zHqv/us.NQge3AerLFW/PWS1GhVglFOZpqKlWL.', 'fadhil', 'fadhil', 'example@gmail.com', '', 'admin', ''),
(85, 'fadhil800', '$2y$10$J88Vf/fzfkZdOvOJRzPCEubRIQehoSmtJ5gojDjwXpUwyE1zqncS.', 'fadhil', 'fadhil', 'example2@gmail.com', '', 'user', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_online`
--

CREATE TABLE `users_online` (
  `id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users_online`
--

INSERT INTO `users_online` (`id`, `session`, `time`) VALUES
(1, '8ir7tknn9gurdu6kv067lo8v3o', 1719381579),
(2, 'f5o08hs7avhuhkfbcipioar53o', 1719381439),
(3, 'hc7sio30hatf3ke9ihumdrdnqp', 1719428132),
(4, 'n5ghahqu2jjhenerm21a8pjpnf', 1719471574),
(5, 'ihgujkvfn6gdirr3l6khr0fohl', 1719503421),
(6, 'fovpendq7hqts2h7d4dqho9drb', 1719576438),
(7, '5u3tk0fphlkbje75mfj3fghmtb', 1719637032),
(8, '9tfim1it7h7ffmr94kad7mid1a', 1719680371),
(9, 'oqs8le4tltf4fd9a4o0bf0ugki', 1719716854),
(10, 'rrj7uc2hkiio2fsd7deqoj6um7', 1719764289),
(11, '5h6ouoa05rpshqpninjsabtkp1', 1719841891);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indeks untuk tabel `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indeks untuk tabel `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indeks untuk tabel `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeks untuk tabel `users_online`
--
ALTER TABLE `users_online`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(99) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT untuk tabel `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT untuk tabel `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT untuk tabel `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT untuk tabel `users_online`
--
ALTER TABLE `users_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
