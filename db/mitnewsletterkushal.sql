-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2025 at 09:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `salmannewsletter`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `full_name`, `password`, `created_at`) VALUES
(1, 'admin', 'Kushal Kamble', '$2y$10$z0PgXNPc8MX1pWU25AKzjuMuplf.41EMJwUP5C9uNHVUDsGPWKz6W', '2025-08-11 06:54:42');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`) VALUES
(1, 'This weeks insights', 'this-weeks-insights', NULL, '2025-08-28 07:39:01'),
(2, 'Quick bytes', 'quick-bytes', NULL, '2025-08-28 07:39:01'),
(3, 'AI tip of the week', 'ai-tip-week', NULL, '2025-08-28 07:39:01'),
(4, 'Toolbox', 'toolbox', NULL, '2025-08-28 07:39:01'),
(5, 'Market news', 'market-news', NULL, '2025-08-28 07:39:01'),
(6, 'Wellnessbyte', 'wellnessbyte', NULL, '2025-08-28 07:39:01'),
(7, 'Quote of the day', 'quote-of-the-day', NULL, '2025-08-28 07:39:01');

-- --------------------------------------------------------

--
-- Table structure for table `component_master`
--

CREATE TABLE `component_master` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subcategory` varchar(150) DEFAULT NULL,
  `content_type` enum('text','image','video','link','mixed') NOT NULL DEFAULT 'text',
  `content` longtext DEFAULT NULL,
  `used_in` tinyint(1) DEFAULT 0,
  `used_in_post_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `media_file` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `component_master`
--

INSERT INTO `component_master` (`id`, `category_id`, `title`, `subcategory`, `content_type`, `content`, `used_in`, `used_in_post_id`, `created_at`, `updated_at`, `media_file`, `status`) VALUES
(4, 1, 'Sample Insight KUSHAL', 'Sample Insight', 'text', 'TEST KAMBLE', 1, NULL, '2025-08-29 09:19:08', '2025-08-29 09:33:27', NULL, 'draft'),
(6, 2, 'Quick test title', 'Quick test subcategory', 'text', '', 1, NULL, '2025-09-02 04:36:22', '2025-09-02 06:55:03', NULL, 'draft'),
(8, 7, 'Quote motivation test', 'Quote motivation test', 'image', 'New joiner integration and faster productivity', 1, NULL, '2025-09-03 07:21:41', '2025-09-03 07:32:10', NULL, 'draft'),
(9, 5, 'Market News title', 'Market News subcategory', 'image', 'subcategory Sales team capabilities through targeted skill development', 1, NULL, '2025-09-03 07:22:39', '2025-09-04 05:41:55', NULL, 'draft'),
(10, 3, 'friday ai', 'friday ai sub', 'text', '<p><strong>✨ Welcome to Our Awesome AI-Powered Portal 🎉</strong><br />\\r\\n👋 Hello <strong>User</strong>,</p>\\r\\n\\r\\n<p>We&rsquo;re super excited to have you here! 💡 This editor allows you to create rich content with style, emojis, and smart formatting. 😍 Plus, with the power of AI tools 🤖, you can now write faster, smarter, and more creatively than ever before.</p>\\r\\n\\r\\n<p>🚀 Key Features You&rsquo;ll Love</p>\\r\\n\\r\\n<ul>\\r\\n	<li>✅ Write &amp; Edit with bold, italic, and underline</li>\\r\\n	<li>✅ Insert links 🔗, images 🖼️, and tables 📊</li>\\r\\n	<li>✅ Organize your work with lists:</li>\\r\\n	<li>🎯 Stay focused on your goals</li>\\r\\n</ul>\\r\\n\\r\\n<p>📌 Keep your notes handy</p>\\r\\n\\r\\n<ol>\\r\\n	<li>🕒 Save valuable time</li>\\r\\n	<li>🤖 How AI Tools Can Help You</li>\\r\\n	<li>📝 Content Writing: Generate blogs, articles, and social posts in seconds.</li>\\r\\n	<li>🎨 Creative Ideas: Get smart suggestions for designs, campaigns, and brainstorming.</li>\\r\\n	<li>📊 Data Insights: Let AI summarize reports and highlight key points.</li>\\r\\n	<li>🌐 Language Support: Instantly translate and reach global audiences.</li>\\r\\n</ol>\\r\\n\\r\\n<p>💬 Smart Chatbots: Provide 24/7 customer support automatically.</p>\\r\\n\\r\\n<p>💡 Pro Tips</p>\\r\\n\\r\\n<ol>\\r\\n	<li>✍️ Start with a clear headline &amp; add a short summary.</li>\\r\\n	<li>🧩 Use sections (H2/H3) to keep content structured.</li>\\r\\n	<li>🔁 Iterate quickly&mdash;draft, refine, and publish.</li>\\r\\n	<li>🚦 Ready to create something amazing? Hit &ldquo;Save&rdquo; 💾, share 📤, and inspire your audience today! 🌟</li>\\r\\n</ol>\\r\\n', 1, NULL, '2025-09-04 05:55:42', '2025-09-04 05:57:27', '1756965342_Admission-mob-Banner (61).jpg', 'published'),
(11, 4, 'Tool September ', 'Tool September  Subcategory ', 'text', 'test', 0, NULL, '2025-09-04 07:36:03', NULL, NULL, 'draft'),
(12, 6, 'Wellness Title', 'Wellness New Subcategory', 'text', 'test', 1, NULL, '2025-09-04 08:23:30', '2025-09-04 08:27:26', NULL, 'draft'),
(13, 1, 'This Week Insights Title', 'This Week Insights Title Subcategory', 'text', 'This Week Insights Content', 0, NULL, '2025-09-04 08:38:20', NULL, NULL, 'draft');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_logs`
--

CREATE TABLE `newsletter_logs` (
  `id` int(11) NOT NULL,
  `newsletter_id` int(11) DEFAULT NULL,
  `subscriber_email` varchar(255) DEFAULT NULL,
  `status` enum('sent','failed') NOT NULL DEFAULT 'sent',
  `error_msg` text DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsletter_logs`
--

INSERT INTO `newsletter_logs` (`id`, `newsletter_id`, `subscriber_email`, `status`, `error_msg`, `sent_at`) VALUES
(166, NULL, 'kushal.kamble@mitsde.com', 'sent', NULL, '2025-09-12 18:55:25'),
(167, NULL, 'kushal.kamble1806@gmail.com', 'sent', NULL, '2025-09-12 18:55:33'),
(168, NULL, 'kushal.kamble@mitsde.com', 'sent', NULL, '2025-09-12 19:04:57'),
(169, NULL, 'kushal.kamble1806@gmail.com', 'sent', NULL, '2025-09-12 19:05:04');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_master`
--

CREATE TABLE `newsletter_master` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory` varchar(150) DEFAULT NULL,
  `editor_content` longtext DEFAULT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `video` varchar(1000) DEFAULT NULL,
  `links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`links`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `scheduled_at` datetime DEFAULT NULL,
  `sent_status` enum('pending','sent','failed') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_master_all`
--

CREATE TABLE `newsletter_master_all` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory` varchar(150) DEFAULT NULL,
  `editor_content` longtext DEFAULT NULL,
  `image` varchar(1000) DEFAULT NULL,
  `video` varchar(1000) DEFAULT NULL,
  `links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`links`)),
  `multi_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`multi_content`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `scheduled_at` datetime DEFAULT NULL,
  `sent_status` enum('pending','sent','failed') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsletter_master_all`
--

INSERT INTO `newsletter_master_all` (`id`, `title`, `category_id`, `subcategory`, `editor_content`, `image`, `video`, `links`, `multi_content`, `created_at`, `updated_at`, `scheduled_at`, `sent_status`) VALUES
(1, 'MITSDE WORKSMARTS', 1, 'this week title volumn 1', '<p><strong>This Week&rsquo;s Insights</strong></p>\r\n\r\n<ol>\r\n	<li>🚀 Fresh Perspectives for Your Week</li>\r\n	<li>✅ Discover trending topics shaping tech and business.</li>\r\n	<li>✅ Deep dives into industry shifts and upcoming opportunities.</li>\r\n	<li>✅ Actionable strategies to stay ahead of the curve.</li>\r\n	<li>🎯 A quick, powerful read to boost your decision-making.<br />\r\n	&nbsp;</li>\r\n</ol>\r\n', 'https://mitsde.com/assets/images/homeimages/MITSDE-Banner.jpg', 'https://youtube.com/shorts/3I1eG3cnQlw?si=l_p0xXEJcssTvyQT', NULL, '{\"this_weeks_insights\":{\"label\":\"This Week\\u2019s Insights\",\"category_id\":1,\"subcategory\":\"this week title volumn 1\",\"content\":\"<p><strong>This Week&rsquo;s Insights</strong></p>\\r\\n\\r\\n<ol>\\r\\n\\t<li>\\ud83d\\ude80 Fresh Perspectives for Your Week</li>\\r\\n\\t<li>\\u2705 Discover trending topics shaping tech and business.</li>\\r\\n\\t<li>\\u2705 Deep dives into industry shifts and upcoming opportunities.</li>\\r\\n\\t<li>\\u2705 Actionable strategies to stay ahead of the curve.</li>\\r\\n\\t<li>\\ud83c\\udfaf A quick, powerful read to boost your decision-making.<br />\\r\\n\\t&nbsp;</li>\\r\\n</ol>\\r\\n\",\"post_id\":5,\"post_url\":\"http://localhost/salmannewsletter/public/post.php?id=5\"},\"quick_bytes\":{\"label\":\"Quick Bytes\",\"category_id\":2,\"subcategory\":\"Quick title volumn 1\",\"content\":\"<p><strong>Quick Bytes</strong></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>\\u26a1 Small Nuggets, Big Impact</li>\\r\\n\\t<li>\\u2705 Bite-sized tips on productivity, learning, and tools.</li>\\r\\n\\t<li>\\u2705 Curated links \\ud83d\\udd17 to must-read articles and resources.</li>\\r\\n\\t<li>\\u2705 Fast facts \\ud83d\\udcca to stay informed without information overload.</li>\\r\\n\\t<li>\\ud83d\\udccc Perfect for a 2-minute coffee break update.</li>\\r\\n</ul>\\r\\n\",\"post_id\":3,\"post_url\":\"http://localhost/salmannewsletter/public/post.php?id=3\"},\"ai_tip\":{\"label\":\"AI Tip of the Week\",\"category_id\":3,\"subcategory\":\"Ai tips title volumn 1\",\"content\":\"<p><strong>AI Tip of the Week</strong></p>\\r\\n\\r\\n<p>\\ud83e\\udd16 Unlock AI&rsquo;s Potential<br />\\r\\n\\u2705 Practical advice for using AI tools effectively.<br />\\r\\n\\u2705 How to automate small tasks and save time.<br />\\r\\n\\u2705 Quick demonstrations for beginners and pros.<br />\\r\\n\\ud83d\\udd52 Boost efficiency with smart AI shortcuts.</p>\\r\\n\",\"post_id\":1,\"post_url\":\"http://localhost/salmannewsletter/public/post.php?id=1\"},\"toolbox\":{\"label\":\"Toolbox\",\"category_id\":4,\"subcategory\":\"toolbox title volumn 1\",\"content\":\"<p><strong>Toolbox</strong></p>\\r\\n\\r\\n<p>\\ud83d\\udee0 Your Go-To Resource Hub<br />\\r\\n\\u2705 Highlighted apps, plugins, and frameworks worth trying.<br />\\r\\n\\u2705 Step-by-step guidance for setup or best practices.<br />\\r\\n\\u2705 Tested recommendations that improve workflow.<br />\\r\\n\\ud83d\\udccc Keep this section handy for future projects.</p>\\r\\n\",\"post_id\":6,\"post_url\":\"http://localhost/salmannewsletter/public/post.php?id=6\"},\"market_news\":{\"label\":\"Market News\",\"category_id\":5,\"subcategory\":\"Market news title  volumn 1\",\"content\":\"<p><strong>Market News</strong></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>\\ud83d\\udcc8 Stay Ahead of the Trends</li>\\r\\n\\t<li>\\u2705 Key updates from finance, startups, and technology.</li>\\r\\n\\t<li>\\u2705 Simplified analysis for quick understanding.</li>\\r\\n\\t<li>\\u2705 Charts \\ud83d\\udcca and snapshots that reveal the bigger picture.</li>\\r\\n\\t<li>\\ud83c\\udfaf Stay informed to make smarter moves.</li>\\r\\n</ul>\\r\\n\",\"post_id\":2,\"post_url\":\"http://localhost/salmannewsletter/public/post.php?id=2\"},\"wellnessbyte\":{\"label\":\"Wellnessbyte\",\"category_id\":6,\"subcategory\":\"wellness title volumn 1\",\"content\":\"<p><strong>Wellnessbyte</strong></p>\\r\\n\\r\\n<p>\\ud83c\\udf31 Balance Work and Well-Being<br />\\r\\n\\u2705 Simple tips for mental clarity and focus.<br />\\r\\n\\u2705 Quick exercises or mindfulness hacks \\ud83e\\uddd8.<br />\\r\\n\\u2705 Nutrition and lifestyle pointers for busy professionals.<br />\\r\\n\\ud83d\\udd52 Small actions, big long-term benefits.</p>\\r\\n\",\"post_id\":7,\"post_url\":\"http://localhost/salmannewsletter/public/post.php?id=7\"},\"quote_of_the_day\":{\"label\":\"Quote of the Day\",\"category_id\":7,\"subcategory\":\"Quote title volumn 1\",\"content\":\"<p><strong>Quote of the Day</strong></p>\\r\\n\\r\\n<p>\\ud83d\\udca1 Inspiration to Power Your Day<br />\\r\\n\\u2705 A thought-provoking quote to spark creativity.<br />\\r\\n\\u2705 A one-line reflection or takeaway.<br />\\r\\n\\ud83d\\udccc Use it as your mantra or share with your team.<br />\\r\\n\\ud83c\\udfaf A little wisdom to keep your motivation high.</p>\\r\\n\",\"post_id\":4,\"post_url\":\"http://localhost/salmannewsletter/public/post.php?id=4\"}}', '2025-09-12 18:55:17', '2025-09-12 18:55:33', NULL, 'sent'),
(2, 'MITSDE WORKSMARTS', 1, '', '<p><strong>This Week&rsquo;s Insights</strong></p>\r\n\r\n<ol>\r\n	<li>🚀 Fresh Perspectives for Your Week</li>\r\n	<li>✅ Discover trending topics shaping tech and business.</li>\r\n	<li>✅ Deep dives into industry shifts and upcoming opportunities.</li>\r\n	<li>✅ Actionable strategies to stay ahead of the curve.</li>\r\n	<li>🎯 A quick, powerful read to boost your decision-making.<br />\r\n	&nbsp;</li>\r\n</ol>\r\n', 'https://mitsde.com/assets/images/homeimages/MITSDE-Banner.jpg', 'https://youtube.com/shorts/3I1eG3cnQlw?si=l_p0xXEJcssTvyQT', NULL, '{\"this_weeks_insights\":{\"label\":\"This Week\\u2019s Insights\",\"category_id\":1,\"subcategory\":\"\",\"content\":\"<p><strong>This Week&rsquo;s Insights</strong></p>\\r\\n\\r\\n<ol>\\r\\n\\t<li>\\ud83d\\ude80 Fresh Perspectives for Your Week</li>\\r\\n\\t<li>\\u2705 Discover trending topics shaping tech and business.</li>\\r\\n\\t<li>\\u2705 Deep dives into industry shifts and upcoming opportunities.</li>\\r\\n\\t<li>\\u2705 Actionable strategies to stay ahead of the curve.</li>\\r\\n\\t<li>\\ud83c\\udfaf A quick, powerful read to boost your decision-making.<br />\\r\\n\\t&nbsp;</li>\\r\\n</ol>\\r\\n\",\"post_id\":null,\"post_url\":null},\"quick_bytes\":{\"label\":\"Quick Bytes\",\"category_id\":2,\"subcategory\":\"\",\"content\":\"<p><strong>Quick Bytes</strong></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>\\u26a1 Small Nuggets, Big Impact</li>\\r\\n\\t<li>\\u2705 Bite-sized tips on productivity, learning, and tools.</li>\\r\\n\\t<li>\\u2705 Curated links \\ud83d\\udd17 to must-read articles and resources.</li>\\r\\n\\t<li>\\u2705 Fast facts \\ud83d\\udcca to stay informed without information overload.</li>\\r\\n\\t<li>\\ud83d\\udccc Perfect for a 2-minute coffee break update.</li>\\r\\n</ul>\\r\\n\",\"post_id\":null,\"post_url\":null},\"ai_tip\":{\"label\":\"AI Tip of the Week\",\"category_id\":3,\"subcategory\":\"\",\"content\":\"<p><strong>AI Tip of the Week</strong></p>\\r\\n\\r\\n<p>\\ud83e\\udd16 Unlock AI&rsquo;s Potential<br />\\r\\n\\u2705 Practical advice for using AI tools effectively.<br />\\r\\n\\u2705 How to automate small tasks and save time.<br />\\r\\n\\u2705 Quick demonstrations for beginners and pros.<br />\\r\\n\\ud83d\\udd52 Boost efficiency with smart AI shortcuts.</p>\\r\\n\",\"post_id\":null,\"post_url\":null},\"toolbox\":{\"label\":\"Toolbox\",\"category_id\":4,\"subcategory\":\"\",\"content\":\"<p><strong>Toolbox</strong></p>\\r\\n\\r\\n<p>\\ud83d\\udee0 Your Go-To Resource Hub<br />\\r\\n\\u2705 Highlighted apps, plugins, and frameworks worth trying.<br />\\r\\n\\u2705 Step-by-step guidance for setup or best practices.<br />\\r\\n\\u2705 Tested recommendations that improve workflow.<br />\\r\\n\\ud83d\\udccc Keep this section handy for future projects.</p>\\r\\n\",\"post_id\":null,\"post_url\":null},\"market_news\":{\"label\":\"Market News\",\"category_id\":5,\"subcategory\":\"\",\"content\":\"<p><strong>Market News</strong></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>\\ud83d\\udcc8 Stay Ahead of the Trends</li>\\r\\n\\t<li>\\u2705 Key updates from finance, startups, and technology.</li>\\r\\n\\t<li>\\u2705 Simplified analysis for quick understanding.</li>\\r\\n\\t<li>\\u2705 Charts \\ud83d\\udcca and snapshots that reveal the bigger picture.</li>\\r\\n\\t<li>\\ud83c\\udfaf Stay informed to make smarter moves.</li>\\r\\n</ul>\\r\\n\",\"post_id\":null,\"post_url\":null},\"wellnessbyte\":{\"label\":\"Wellnessbyte\",\"category_id\":6,\"subcategory\":\"\",\"content\":\"<p><strong>Wellnessbyte</strong></p>\\r\\n\\r\\n<p>\\ud83c\\udf31 Balance Work and Well-Being<br />\\r\\n\\u2705 Simple tips for mental clarity and focus.<br />\\r\\n\\u2705 Quick exercises or mindfulness hacks \\ud83e\\uddd8.<br />\\r\\n\\u2705 Nutrition and lifestyle pointers for busy professionals.<br />\\r\\n\\ud83d\\udd52 Small actions, big long-term benefits.</p>\\r\\n\",\"post_id\":null,\"post_url\":null},\"quote_of_the_day\":{\"label\":\"Quote of the Day\",\"category_id\":7,\"subcategory\":\"\",\"content\":\"<p><strong>Quote of the Day</strong></p>\\r\\n\\r\\n<p>\\ud83d\\udca1 Inspiration to Power Your Day<br />\\r\\n\\u2705 A thought-provoking quote to spark creativity.<br />\\r\\n\\u2705 A one-line reflection or takeaway.<br />\\r\\n\\ud83d\\udccc Use it as your mantra or share with your team.<br />\\r\\n\\ud83c\\udfaf A little wisdom to keep your motivation high.</p>\\r\\n\",\"post_id\":null,\"post_url\":null}}', '2025-09-12 19:04:50', '2025-09-12 19:05:04', NULL, 'sent');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext DEFAULT NULL,
  `post_date` date DEFAULT curdate(),
  `author_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory` varchar(150) DEFAULT NULL,
  `main_media` varchar(1000) DEFAULT NULL,
  `links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`links`)),
  `component_id` int(11) DEFAULT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `description`, `post_date`, `author_id`, `category_id`, `subcategory`, `main_media`, `links`, `component_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ai tips title', '<h3><strong>Ai tips title volumn 1</strong></h3>\r\n\r\n<p>🚀&nbsp;<strong>Fresh Perspectives for Your Week</strong></p>\r\n\r\n<p>In today&rsquo;s fast-moving world, staying ahead means understanding the shifts that drive technology, business, and innovation.&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;is your trusted source for decoding these changes and turning information into opportunity. Each edition is carefully curated to bring you meaningful updates and strategies you can act on right away.</p>\r\n\r\n<p><strong>📈 Stay Ahead of the Trends</strong></p>\r\n\r\n<ul>\r\n	<li>✅ Key updates from finance, startups, and technology.</li>\r\n	<li>✅ Simplified analysis for quick understanding.</li>\r\n	<li>✅ Charts 📊 and snapshots that reveal the bigger picture.</li>\r\n	<li>🎯 Stay informed to make smarter moves.</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Discover Emerging Trends Shaping Industries Worldwide</strong><br />\r\nFrom breakthrough artificial intelligence models and revolutionary software tools to surprising market moves by startups, innovation is happening at lightning speed. This section filters through the noise to highlight the developments that matter most. Whether it&rsquo;s a new AI-powered design platform changing the creative industry or a funding trend reshaping the startup ecosystem, you&rsquo;ll always be in the know.</p>\r\n\r\n<p><strong>Quick Bytes</strong></p>\r\n\r\n<ol>\r\n	<li>⚡ Small Nuggets, Big&nbsp;<a href=\"https://manus.im/\" target=\"_blank\">manus ai</a></li>\r\n	<li>✅ Bite-sized tips on productivity, learning, and tools.</li>\r\n	<li>✅ Curated links 🔗 to must-read articles and resources.</li>\r\n	<li>✅ Fast facts 📊 to stay informed without information overload.</li>\r\n	<li>📌 Perfect for a 2-minute coffee break update.</li>\r\n</ol>\r\n\r\n<p>✅&nbsp;<strong>Deep-Dive Analyses for Smarter Decisions</strong><br />\r\nWe go beyond surface-level headlines to unpack what&rsquo;s really happening. Why are venture capital investments shifting toward sustainable tech? What does the latest government policy mean for data privacy or fintech regulation? These insights give you the foresight to anticipate opportunities and challenges before they fully emerge.</p>\r\n\r\n<p><br />\r\n<strong>AI Tip of the Week</strong></p>\r\n\r\n<ul>\r\n	<li>🤖 Unlock AI&rsquo;s&nbsp;<a href=\"https://gemini.google.com/app\" target=\"_blank\">gemini ai</a></li>\r\n	<li>✅ Practical advice for using AI tools effectively.</li>\r\n	<li>✅ How to automate small tasks and save time.</li>\r\n	<li>✅ Quick demonstrations for beginners and pros.</li>\r\n	<li>🕒 Boost efficiency with smart AI shortcuts.&nbsp;</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Actionable Strategies and Growth Hacks</strong><br />\r\nInformation alone isn&rsquo;t enough&mdash;you need practical steps you can take. Every piece of analysis includes clear, actionable strategies. Whether you&rsquo;re a developer adopting a new framework, an entrepreneur exploring a pivot, or a professional seeking an edge in your career, you&rsquo;ll find advice tailored to your context.</p>\r\n\r\n<p>🎯&nbsp;<strong>Your Mini Playbook for the Week Ahead</strong><br />\r\nThink of&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;as a powerful yet quick read&mdash;something you can absorb over your morning coffee but rely on throughout the week. It&rsquo;s like having a personal strategist in your inbox: guiding you through shifting markets, emerging technologies, and business opportunities. The aim isn&rsquo;t just to inform&mdash;it&rsquo;s to equip you with the clarity and confidence to act decisively.</p>\r\n\r\n<p>By the end of each week, you won&rsquo;t just know what&rsquo;s trending&mdash;you&rsquo;ll understand&nbsp;<em>why it matters</em>&nbsp;and how to position yourself ahead of the curve. Whether you&rsquo;re steering a team, running a startup, or building your personal skill set, these insights will become an essential part of your decision-making toolkit.</p>\r\n', '2025-09-12', 1, 3, 'Ai tips title volumn 1', '1757701540_image1.jpg', NULL, NULL, 'published', '2025-09-12 18:25:40', NULL),
(2, 'Market news title', '<h3><strong>Market news title &nbsp;volumn 1</strong></h3>\r\n\r\n<p>🚀&nbsp;<strong>Fresh Perspectives for Your Week</strong></p>\r\n\r\n<p>In today&rsquo;s fast-moving world, staying ahead means understanding the shifts that drive technology, business, and innovation.&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;is your trusted source for decoding these changes and turning information into opportunity. Each edition is carefully curated to bring you meaningful updates and strategies you can act on right away.</p>\r\n\r\n<p><strong>📈 Stay Ahead of the Trends</strong></p>\r\n\r\n<ul>\r\n	<li>✅ Key updates from finance, startups, and technology.</li>\r\n	<li>✅ Simplified analysis for quick understanding.</li>\r\n	<li>✅ Charts 📊 and snapshots that reveal the bigger picture.</li>\r\n	<li>🎯 Stay informed to make smarter moves.</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Discover Emerging Trends Shaping Industries Worldwide</strong><br />\r\nFrom breakthrough artificial intelligence models and revolutionary software tools to surprising market moves by startups, innovation is happening at lightning speed. This section filters through the noise to highlight the developments that matter most. Whether it&rsquo;s a new AI-powered design platform changing the creative industry or a funding trend reshaping the startup ecosystem, you&rsquo;ll always be in the know.</p>\r\n\r\n<p><strong>Quick Bytes</strong></p>\r\n\r\n<ol>\r\n	<li>⚡ Small Nuggets, Big&nbsp;<a href=\"https://manus.im/\" target=\"_blank\">manus ai</a></li>\r\n	<li>✅ Bite-sized tips on productivity, learning, and tools.</li>\r\n	<li>✅ Curated links 🔗 to must-read articles and resources.</li>\r\n	<li>✅ Fast facts 📊 to stay informed without information overload.</li>\r\n	<li>📌 Perfect for a 2-minute coffee break update.</li>\r\n</ol>\r\n\r\n<p>✅&nbsp;<strong>Deep-Dive Analyses for Smarter Decisions</strong><br />\r\nWe go beyond surface-level headlines to unpack what&rsquo;s really happening. Why are venture capital investments shifting toward sustainable tech? What does the latest government policy mean for data privacy or fintech regulation? These insights give you the foresight to anticipate opportunities and challenges before they fully emerge.</p>\r\n\r\n<p><br />\r\n<strong>AI Tip of the Week</strong></p>\r\n\r\n<ul>\r\n	<li>🤖 Unlock AI&rsquo;s&nbsp;<a href=\"https://gemini.google.com/app\" target=\"_blank\">gemini ai</a></li>\r\n	<li>✅ Practical advice for using AI tools effectively.</li>\r\n	<li>✅ How to automate small tasks and save time.</li>\r\n	<li>✅ Quick demonstrations for beginners and pros.</li>\r\n	<li>🕒 Boost efficiency with smart AI shortcuts.&nbsp;</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Actionable Strategies and Growth Hacks</strong><br />\r\nInformation alone isn&rsquo;t enough&mdash;you need practical steps you can take. Every piece of analysis includes clear, actionable strategies. Whether you&rsquo;re a developer adopting a new framework, an entrepreneur exploring a pivot, or a professional seeking an edge in your career, you&rsquo;ll find advice tailored to your context.</p>\r\n\r\n<p>🎯&nbsp;<strong>Your Mini Playbook for the Week Ahead</strong><br />\r\nThink of&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;as a powerful yet quick read&mdash;something you can absorb over your morning coffee but rely on throughout the week. It&rsquo;s like having a personal strategist in your inbox: guiding you through shifting markets, emerging technologies, and business opportunities. The aim isn&rsquo;t just to inform&mdash;it&rsquo;s to equip you with the clarity and confidence to act decisively.</p>\r\n\r\n<p>By the end of each week, you won&rsquo;t just know what&rsquo;s trending&mdash;you&rsquo;ll understand&nbsp;<em>why it matters</em>&nbsp;and how to position yourself ahead of the curve. Whether you&rsquo;re steering a team, running a startup, or building your personal skill set, these insights will become an essential part of your decision-making toolkit.</p>\r\n', '2025-09-12', 1, 5, 'Market news title  volumn 1', '1757701631_image3.jpg', NULL, NULL, 'published', '2025-09-12 18:27:11', NULL),
(3, 'Quick title', '<h3><strong>Quick title volumn 1</strong></h3>\r\n\r\n<p>🚀&nbsp;<strong>Fresh Perspectives for Your Week</strong></p>\r\n\r\n<p>In today&rsquo;s fast-moving world, staying ahead means understanding the shifts that drive technology, business, and innovation.&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;is your trusted source for decoding these changes and turning information into opportunity. Each edition is carefully curated to bring you meaningful updates and strategies you can act on right away.</p>\r\n\r\n<p><strong>📈 Stay Ahead of the Trends</strong></p>\r\n\r\n<ul>\r\n	<li>✅ Key updates from finance, startups, and technology.</li>\r\n	<li>✅ Simplified analysis for quick understanding.</li>\r\n	<li>✅ Charts 📊 and snapshots that reveal the bigger picture.</li>\r\n	<li>🎯 Stay informed to make smarter moves.</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Discover Emerging Trends Shaping Industries Worldwide</strong><br />\r\nFrom breakthrough artificial intelligence models and revolutionary software tools to surprising market moves by startups, innovation is happening at lightning speed. This section filters through the noise to highlight the developments that matter most. Whether it&rsquo;s a new AI-powered design platform changing the creative industry or a funding trend reshaping the startup ecosystem, you&rsquo;ll always be in the know.</p>\r\n\r\n<p><strong>Quick Bytes</strong></p>\r\n\r\n<ol>\r\n	<li>⚡ Small Nuggets, Big&nbsp;<a href=\"https://manus.im/\" target=\"_blank\">manus ai</a></li>\r\n	<li>✅ Bite-sized tips on productivity, learning, and tools.</li>\r\n	<li>✅ Curated links 🔗 to must-read articles and resources.</li>\r\n	<li>✅ Fast facts 📊 to stay informed without information overload.</li>\r\n	<li>📌 Perfect for a 2-minute coffee break update.</li>\r\n</ol>\r\n\r\n<p>✅&nbsp;<strong>Deep-Dive Analyses for Smarter Decisions</strong><br />\r\nWe go beyond surface-level headlines to unpack what&rsquo;s really happening. Why are venture capital investments shifting toward sustainable tech? What does the latest government policy mean for data privacy or fintech regulation? These insights give you the foresight to anticipate opportunities and challenges before they fully emerge.</p>\r\n\r\n<p><br />\r\n<strong>AI Tip of the Week</strong></p>\r\n\r\n<ul>\r\n	<li>🤖 Unlock AI&rsquo;s&nbsp;<a href=\"https://gemini.google.com/app\" target=\"_blank\">gemini ai</a></li>\r\n	<li>✅ Practical advice for using AI tools effectively.</li>\r\n	<li>✅ How to automate small tasks and save time.</li>\r\n	<li>✅ Quick demonstrations for beginners and pros.</li>\r\n	<li>🕒 Boost efficiency with smart AI shortcuts.&nbsp;</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Actionable Strategies and Growth Hacks</strong><br />\r\nInformation alone isn&rsquo;t enough&mdash;you need practical steps you can take. Every piece of analysis includes clear, actionable strategies. Whether you&rsquo;re a developer adopting a new framework, an entrepreneur exploring a pivot, or a professional seeking an edge in your career, you&rsquo;ll find advice tailored to your context.</p>\r\n\r\n<p>🎯&nbsp;<strong>Your Mini Playbook for the Week Ahead</strong><br />\r\nThink of&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;as a powerful yet quick read&mdash;something you can absorb over your morning coffee but rely on throughout the week. It&rsquo;s like having a personal strategist in your inbox: guiding you through shifting markets, emerging technologies, and business opportunities. The aim isn&rsquo;t just to inform&mdash;it&rsquo;s to equip you with the clarity and confidence to act decisively.</p>\r\n\r\n<p>By the end of each week, you won&rsquo;t just know what&rsquo;s trending&mdash;you&rsquo;ll understand&nbsp;<em>why it matters</em>&nbsp;and how to position yourself ahead of the curve. Whether you&rsquo;re steering a team, running a startup, or building your personal skill set, these insights will become an essential part of your decision-making toolkit.</p>\r\n', '2025-09-12', 1, 2, 'Quick title volumn 1', '1757701683_image2.jpg', NULL, NULL, 'published', '2025-09-12 18:28:03', NULL),
(4, 'Quote title ', '<h3><strong>Quote title volumn 1</strong></h3>\r\n\r\n<p>🚀&nbsp;<strong>Fresh Perspectives for Your Week</strong></p>\r\n\r\n<p>In today&rsquo;s fast-moving world, staying ahead means understanding the shifts that drive technology, business, and innovation.&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;is your trusted source for decoding these changes and turning information into opportunity. Each edition is carefully curated to bring you meaningful updates and strategies you can act on right away.</p>\r\n\r\n<p><strong>📈 Stay Ahead of the Trends</strong></p>\r\n\r\n<ul>\r\n	<li>✅ Key updates from finance, startups, and technology.</li>\r\n	<li>✅ Simplified analysis for quick understanding.</li>\r\n	<li>✅ Charts 📊 and snapshots that reveal the bigger picture.</li>\r\n	<li>🎯 Stay informed to make smarter moves.</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Discover Emerging Trends Shaping Industries Worldwide</strong><br />\r\nFrom breakthrough artificial intelligence models and revolutionary software tools to surprising market moves by startups, innovation is happening at lightning speed. This section filters through the noise to highlight the developments that matter most. Whether it&rsquo;s a new AI-powered design platform changing the creative industry or a funding trend reshaping the startup ecosystem, you&rsquo;ll always be in the know.</p>\r\n\r\n<p><strong>Quick Bytes</strong></p>\r\n\r\n<ol>\r\n	<li>⚡ Small Nuggets, Big&nbsp;<a href=\"https://manus.im/\" target=\"_blank\">manus ai</a></li>\r\n	<li>✅ Bite-sized tips on productivity, learning, and tools.</li>\r\n	<li>✅ Curated links 🔗 to must-read articles and resources.</li>\r\n	<li>✅ Fast facts 📊 to stay informed without information overload.</li>\r\n	<li>📌 Perfect for a 2-minute coffee break update.</li>\r\n</ol>\r\n\r\n<p>✅&nbsp;<strong>Deep-Dive Analyses for Smarter Decisions</strong><br />\r\nWe go beyond surface-level headlines to unpack what&rsquo;s really happening. Why are venture capital investments shifting toward sustainable tech? What does the latest government policy mean for data privacy or fintech regulation? These insights give you the foresight to anticipate opportunities and challenges before they fully emerge.</p>\r\n\r\n<p><br />\r\n<strong>AI Tip of the Week</strong></p>\r\n\r\n<ul>\r\n	<li>🤖 Unlock AI&rsquo;s&nbsp;<a href=\"https://gemini.google.com/app\" target=\"_blank\">gemini ai</a></li>\r\n	<li>✅ Practical advice for using AI tools effectively.</li>\r\n	<li>✅ How to automate small tasks and save time.</li>\r\n	<li>✅ Quick demonstrations for beginners and pros.</li>\r\n	<li>🕒 Boost efficiency with smart AI shortcuts.&nbsp;</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Actionable Strategies and Growth Hacks</strong><br />\r\nInformation alone isn&rsquo;t enough&mdash;you need practical steps you can take. Every piece of analysis includes clear, actionable strategies. Whether you&rsquo;re a developer adopting a new framework, an entrepreneur exploring a pivot, or a professional seeking an edge in your career, you&rsquo;ll find advice tailored to your context.</p>\r\n\r\n<p>🎯&nbsp;<strong>Your Mini Playbook for the Week Ahead</strong><br />\r\nThink of&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;as a powerful yet quick read&mdash;something you can absorb over your morning coffee but rely on throughout the week. It&rsquo;s like having a personal strategist in your inbox: guiding you through shifting markets, emerging technologies, and business opportunities. The aim isn&rsquo;t just to inform&mdash;it&rsquo;s to equip you with the clarity and confidence to act decisively.</p>\r\n\r\n<p>By the end of each week, you won&rsquo;t just know what&rsquo;s trending&mdash;you&rsquo;ll understand&nbsp;<em>why it matters</em>&nbsp;and how to position yourself ahead of the curve. Whether you&rsquo;re steering a team, running a startup, or building your personal skill set, these insights will become an essential part of your decision-making toolkit.</p>\r\n', '2025-09-12', 1, 7, 'Quote title volumn 1', '1757701742_image1.jpg', NULL, NULL, 'published', '2025-09-12 18:29:02', NULL),
(5, 'this week ', '<h3><strong>this week title volumn 1</strong></h3>\r\n\r\n<p>🚀&nbsp;<strong>Fresh Perspectives for Your Week</strong></p>\r\n\r\n<p>In today&rsquo;s fast-moving world, staying ahead means understanding the shifts that drive technology, business, and innovation.&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;is your trusted source for decoding these changes and turning information into opportunity. Each edition is carefully curated to bring you meaningful updates and strategies you can act on right away.</p>\r\n\r\n<p><strong>📈 Stay Ahead of the Trends</strong></p>\r\n\r\n<ul>\r\n	<li>✅ Key updates from finance, startups, and technology.</li>\r\n	<li>✅ Simplified analysis for quick understanding.</li>\r\n	<li>✅ Charts 📊 and snapshots that reveal the bigger picture.</li>\r\n	<li>🎯 Stay informed to make smarter moves.</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Discover Emerging Trends Shaping Industries Worldwide</strong><br />\r\nFrom breakthrough artificial intelligence models and revolutionary software tools to surprising market moves by startups, innovation is happening at lightning speed. This section filters through the noise to highlight the developments that matter most. Whether it&rsquo;s a new AI-powered design platform changing the creative industry or a funding trend reshaping the startup ecosystem, you&rsquo;ll always be in the know.</p>\r\n\r\n<p><strong>Quick Bytes</strong></p>\r\n\r\n<ol>\r\n	<li>⚡ Small Nuggets, Big&nbsp;<a href=\"https://manus.im/\" target=\"_blank\">manus ai</a></li>\r\n	<li>✅ Bite-sized tips on productivity, learning, and tools.</li>\r\n	<li>✅ Curated links 🔗 to must-read articles and resources.</li>\r\n	<li>✅ Fast facts 📊 to stay informed without information overload.</li>\r\n	<li>📌 Perfect for a 2-minute coffee break update.</li>\r\n</ol>\r\n\r\n<p>✅&nbsp;<strong>Deep-Dive Analyses for Smarter Decisions</strong><br />\r\nWe go beyond surface-level headlines to unpack what&rsquo;s really happening. Why are venture capital investments shifting toward sustainable tech? What does the latest government policy mean for data privacy or fintech regulation? These insights give you the foresight to anticipate opportunities and challenges before they fully emerge.</p>\r\n\r\n<p><br />\r\n<strong>AI Tip of the Week</strong></p>\r\n\r\n<ul>\r\n	<li>🤖 Unlock AI&rsquo;s&nbsp;<a href=\"https://gemini.google.com/app\" target=\"_blank\">gemini ai</a></li>\r\n	<li>✅ Practical advice for using AI tools effectively.</li>\r\n	<li>✅ How to automate small tasks and save time.</li>\r\n	<li>✅ Quick demonstrations for beginners and pros.</li>\r\n	<li>🕒 Boost efficiency with smart AI shortcuts.&nbsp;</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Actionable Strategies and Growth Hacks</strong><br />\r\nInformation alone isn&rsquo;t enough&mdash;you need practical steps you can take. Every piece of analysis includes clear, actionable strategies. Whether you&rsquo;re a developer adopting a new framework, an entrepreneur exploring a pivot, or a professional seeking an edge in your career, you&rsquo;ll find advice tailored to your context.</p>\r\n\r\n<p>🎯&nbsp;<strong>Your Mini Playbook for the Week Ahead</strong><br />\r\nThink of&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;as a powerful yet quick read&mdash;something you can absorb over your morning coffee but rely on throughout the week. It&rsquo;s like having a personal strategist in your inbox: guiding you through shifting markets, emerging technologies, and business opportunities. The aim isn&rsquo;t just to inform&mdash;it&rsquo;s to equip you with the clarity and confidence to act decisively.</p>\r\n\r\n<p>By the end of each week, you won&rsquo;t just know what&rsquo;s trending&mdash;you&rsquo;ll understand&nbsp;<em>why it matters</em>&nbsp;and how to position yourself ahead of the curve. Whether you&rsquo;re steering a team, running a startup, or building your personal skill set, these insights will become an essential part of your decision-making toolkit.</p>\r\n', '2025-09-12', 1, 1, 'this week title volumn 1', '1757701794_image3.jpg', NULL, NULL, 'published', '2025-09-12 18:29:54', NULL),
(6, 'toolbox title', '<h3><strong>toolbox title volumn 1</strong></h3>\r\n\r\n<p>🚀&nbsp;<strong>Fresh Perspectives for Your Week</strong></p>\r\n\r\n<p>In today&rsquo;s fast-moving world, staying ahead means understanding the shifts that drive technology, business, and innovation.&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;is your trusted source for decoding these changes and turning information into opportunity. Each edition is carefully curated to bring you meaningful updates and strategies you can act on right away.</p>\r\n\r\n<p><strong>📈 Stay Ahead of the Trends</strong></p>\r\n\r\n<ul>\r\n	<li>✅ Key updates from finance, startups, and technology.</li>\r\n	<li>✅ Simplified analysis for quick understanding.</li>\r\n	<li>✅ Charts 📊 and snapshots that reveal the bigger picture.</li>\r\n	<li>🎯 Stay informed to make smarter moves.</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Discover Emerging Trends Shaping Industries Worldwide</strong><br />\r\nFrom breakthrough artificial intelligence models and revolutionary software tools to surprising market moves by startups, innovation is happening at lightning speed. This section filters through the noise to highlight the developments that matter most. Whether it&rsquo;s a new AI-powered design platform changing the creative industry or a funding trend reshaping the startup ecosystem, you&rsquo;ll always be in the know.</p>\r\n\r\n<p><strong>Quick Bytes</strong></p>\r\n\r\n<ol>\r\n	<li>⚡ Small Nuggets, Big&nbsp;<a href=\"https://manus.im/\" target=\"_blank\">manus ai</a></li>\r\n	<li>✅ Bite-sized tips on productivity, learning, and tools.</li>\r\n	<li>✅ Curated links 🔗 to must-read articles and resources.</li>\r\n	<li>✅ Fast facts 📊 to stay informed without information overload.</li>\r\n	<li>📌 Perfect for a 2-minute coffee break update.</li>\r\n</ol>\r\n\r\n<p>✅&nbsp;<strong>Deep-Dive Analyses for Smarter Decisions</strong><br />\r\nWe go beyond surface-level headlines to unpack what&rsquo;s really happening. Why are venture capital investments shifting toward sustainable tech? What does the latest government policy mean for data privacy or fintech regulation? These insights give you the foresight to anticipate opportunities and challenges before they fully emerge.</p>\r\n\r\n<p><br />\r\n<strong>AI Tip of the Week</strong></p>\r\n\r\n<ul>\r\n	<li>🤖 Unlock AI&rsquo;s&nbsp;<a href=\"https://gemini.google.com/app\" target=\"_blank\">gemini ai</a></li>\r\n	<li>✅ Practical advice for using AI tools effectively.</li>\r\n	<li>✅ How to automate small tasks and save time.</li>\r\n	<li>✅ Quick demonstrations for beginners and pros.</li>\r\n	<li>🕒 Boost efficiency with smart AI shortcuts.&nbsp;</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Actionable Strategies and Growth Hacks</strong><br />\r\nInformation alone isn&rsquo;t enough&mdash;you need practical steps you can take. Every piece of analysis includes clear, actionable strategies. Whether you&rsquo;re a developer adopting a new framework, an entrepreneur exploring a pivot, or a professional seeking an edge in your career, you&rsquo;ll find advice tailored to your context.</p>\r\n\r\n<p>🎯&nbsp;<strong>Your Mini Playbook for the Week Ahead</strong><br />\r\nThink of&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;as a powerful yet quick read&mdash;something you can absorb over your morning coffee but rely on throughout the week. It&rsquo;s like having a personal strategist in your inbox: guiding you through shifting markets, emerging technologies, and business opportunities. The aim isn&rsquo;t just to inform&mdash;it&rsquo;s to equip you with the clarity and confidence to act decisively.</p>\r\n\r\n<p>By the end of each week, you won&rsquo;t just know what&rsquo;s trending&mdash;you&rsquo;ll understand&nbsp;<em>why it matters</em>&nbsp;and how to position yourself ahead of the curve. Whether you&rsquo;re steering a team, running a startup, or building your personal skill set, these insights will become an essential part of your decision-making toolkit.</p>\r\n', '2025-09-12', 1, 4, 'toolbox title volumn 1', '1757701840_image3.jpg', NULL, NULL, 'published', '2025-09-11 18:30:40', '2025-09-11 18:47:02'),
(7, 'wellness title', '<h3><strong>wellness title volumn 1</strong></h3>\r\n\r\n<p>🚀&nbsp;<strong>Fresh Perspectives for Your Week</strong></p>\r\n\r\n<p>In today&rsquo;s fast-moving world, staying ahead means understanding the shifts that drive technology, business, and innovation.&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;is your trusted source for decoding these changes and turning information into opportunity. Each edition is carefully curated to bring you meaningful updates and strategies you can act on right away.</p>\r\n\r\n<p><strong>📈 Stay Ahead of the Trends</strong></p>\r\n\r\n<ul>\r\n	<li>✅ Key updates from finance, startups, and technology.</li>\r\n	<li>✅ Simplified analysis for quick understanding.</li>\r\n	<li>✅ Charts 📊 and snapshots that reveal the bigger picture.</li>\r\n	<li>🎯 Stay informed to make smarter moves.</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Discover Emerging Trends Shaping Industries Worldwide</strong><br />\r\nFrom breakthrough artificial intelligence models and revolutionary software tools to surprising market moves by startups, innovation is happening at lightning speed. This section filters through the noise to highlight the developments that matter most. Whether it&rsquo;s a new AI-powered design platform changing the creative industry or a funding trend reshaping the startup ecosystem, you&rsquo;ll always be in the know.</p>\r\n\r\n<p><strong>Quick Bytes</strong></p>\r\n\r\n<ol>\r\n	<li>⚡ Small Nuggets, Big&nbsp;<a href=\"https://manus.im/\" target=\"_blank\">manus ai</a></li>\r\n	<li>✅ Bite-sized tips on productivity, learning, and tools.</li>\r\n	<li>✅ Curated links 🔗 to must-read articles and resources.</li>\r\n	<li>✅ Fast facts 📊 to stay informed without information overload.</li>\r\n	<li>📌 Perfect for a 2-minute coffee break update.</li>\r\n</ol>\r\n\r\n<p>✅&nbsp;<strong>Deep-Dive Analyses for Smarter Decisions</strong><br />\r\nWe go beyond surface-level headlines to unpack what&rsquo;s really happening. Why are venture capital investments shifting toward sustainable tech? What does the latest government policy mean for data privacy or fintech regulation? These insights give you the foresight to anticipate opportunities and challenges before they fully emerge.</p>\r\n\r\n<p><br />\r\n<strong>AI Tip of the Week</strong></p>\r\n\r\n<ul>\r\n	<li>🤖 Unlock AI&rsquo;s&nbsp;<a href=\"https://gemini.google.com/app\" target=\"_blank\">gemini ai</a></li>\r\n	<li>✅ Practical advice for using AI tools effectively.</li>\r\n	<li>✅ How to automate small tasks and save time.</li>\r\n	<li>✅ Quick demonstrations for beginners and pros.</li>\r\n	<li>🕒 Boost efficiency with smart AI shortcuts.&nbsp;</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Actionable Strategies and Growth Hacks</strong><br />\r\nInformation alone isn&rsquo;t enough&mdash;you need practical steps you can take. Every piece of analysis includes clear, actionable strategies. Whether you&rsquo;re a developer adopting a new framework, an entrepreneur exploring a pivot, or a professional seeking an edge in your career, you&rsquo;ll find advice tailored to your context.</p>\r\n\r\n<p>🎯&nbsp;<strong>Your Mini Playbook for the Week Ahead</strong><br />\r\nThink of&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;as a powerful yet quick read&mdash;something you can absorb over your morning coffee but rely on throughout the week. It&rsquo;s like having a personal strategist in your inbox: guiding you through shifting markets, emerging technologies, and business opportunities. The aim isn&rsquo;t just to inform&mdash;it&rsquo;s to equip you with the clarity and confidence to act decisively.</p>\r\n\r\n<p>By the end of each week, you won&rsquo;t just know what&rsquo;s trending&mdash;you&rsquo;ll understand&nbsp;<em>why it matters</em>&nbsp;and how to position yourself ahead of the curve. Whether you&rsquo;re steering a team, running a startup, or building your personal skill set, these insights will become an essential part of your decision-making toolkit.</p>\r\n', '2025-09-12', 1, 6, 'wellness title volumn 1', '1757701881_image2.jpg', NULL, NULL, 'published', '2025-09-11 18:31:21', '2025-09-12 18:54:28');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `name`, `email`, `created_at`, `status`) VALUES
(1, 'Kushal Kamble', 'kushal.kamble@mitsde.com', '2025-08-28 08:55:59', 1),
(3, 'shahrukh khan', 'kushal.kamble1806@gmail.com', '2025-09-02 06:35:40', 1),
(4, 'akshay kumar', 'manager1@gmail.com', '2025-09-02 06:36:05', 0),
(6, 'Amitabh bacchan', 'amitabh@example.com', '2025-09-04 05:17:19', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_categories_slug` (`slug`);

--
-- Indexes for table `component_master`
--
ALTER TABLE `component_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_component_category` (`category_id`);

--
-- Indexes for table `newsletter_logs`
--
ALTER TABLE `newsletter_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_logs_newsletter` (`newsletter_id`),
  ADD KEY `idx_logs_subscriber_email` (`subscriber_email`);

--
-- Indexes for table `newsletter_master`
--
ALTER TABLE `newsletter_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_nl_category` (`category_id`);

--
-- Indexes for table `newsletter_master_all`
--
ALTER TABLE `newsletter_master_all`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_posts_author` (`author_id`),
  ADD KEY `idx_posts_category` (`category_id`),
  ADD KEY `idx_posts_component` (`component_id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `component_master`
--
ALTER TABLE `component_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `newsletter_logs`
--
ALTER TABLE `newsletter_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;

--
-- AUTO_INCREMENT for table `newsletter_master`
--
ALTER TABLE `newsletter_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `newsletter_master_all`
--
ALTER TABLE `newsletter_master_all`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `component_master`
--
ALTER TABLE `component_master`
  ADD CONSTRAINT `fk_component_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `newsletter_logs`
--
ALTER TABLE `newsletter_logs`
  ADD CONSTRAINT `fk_logs_newsletter` FOREIGN KEY (`newsletter_id`) REFERENCES `newsletter_master` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `newsletter_master`
--
ALTER TABLE `newsletter_master`
  ADD CONSTRAINT `fk_nl_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_posts_author` FOREIGN KEY (`author_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_posts_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_posts_component` FOREIGN KEY (`component_id`) REFERENCES `component_master` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
