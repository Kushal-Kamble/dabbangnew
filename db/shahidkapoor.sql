-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3309
-- Generation Time: Sep 13, 2025 at 12:40 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shahidkapoor`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `full_name`, `password`, `created_at`) VALUES
(1, 'admin', 'Kushal Kamble', '$2y$10$z0PgXNPc8MX1pWU25AKzjuMuplf.41EMJwUP5C9uNHVUDsGPWKz6W', '2025-08-11 06:54:42'),
(2, 'kushal_admin', 'Kushal Kamble Dev', '$2y$10$gOSTb.YLX2VLiWgPYnVfS.EU5jRA8hSItUTiEv008ZnIp5OX/L7Ii', '2025-09-13 07:07:52'),
(3, 'Vishal', 'Vishal Kamble', '$2y$10$TrywRtTG4wkw7pLwjMi6Je0caXfBl01EgMgDtHH8fpU1M.xmfEPfO', '2025-09-13 07:14:15');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcategory` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_type` enum('text','image','video','link','mixed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `used_in` tinyint(1) DEFAULT 0,
  `used_in_post_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `media_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `component_master`
--

INSERT INTO `component_master` (`id`, `category_id`, `title`, `subcategory`, `content_type`, `content`, `used_in`, `used_in_post_id`, `created_at`, `updated_at`, `media_file`, `status`) VALUES
(4, 1, 'Sample Insight KUSHAL', 'Sample Insight', 'text', 'TEST KAMBLE', 1, NULL, '2025-08-29 09:19:08', '2025-08-29 09:33:27', NULL, 'draft'),
(6, 2, 'Quick test title', 'Quick test subcategory', 'text', '', 1, NULL, '2025-09-02 04:36:22', '2025-09-02 06:55:03', NULL, 'draft');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_logs`
--

CREATE TABLE `newsletter_logs` (
  `id` int(11) NOT NULL,
  `newsletter_id` int(11) DEFAULT NULL,
  `subscriber_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('sent','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sent',
  `error_msg` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsletter_logs`
--

INSERT INTO `newsletter_logs` (`id`, `newsletter_id`, `subscriber_email`, `status`, `error_msg`, `sent_at`) VALUES
(1, 3, 'kushal.kamble@mitsde.com', 'sent', NULL, '2025-09-13 10:37:16'),
(2, 3, 'kushal.kamble1806@gmail.com', 'sent', NULL, '2025-09-13 10:37:22');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_master`
--

CREATE TABLE `newsletter_master` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `editor_content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`links`)),
  `multi_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`multi_content`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `scheduled_at` datetime DEFAULT NULL,
  `sent_status` enum('pending','sent','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsletter_master`
--

INSERT INTO `newsletter_master` (`id`, `title`, `category_id`, `subcategory`, `editor_content`, `image`, `video`, `links`, `multi_content`, `created_at`, `updated_at`, `scheduled_at`, `sent_status`) VALUES
(3, 'MITSDE WORKSMARTS', 1, 'this week v1', '<p><strong>This Week&rsquo;s Insights</strong></p>\r\n\r\n<p>🚀 Fresh Perspectives for Your Week<br />\r\n✅ Discover trending topics shaping tech and business.<br />\r\n✅ Deep dives into industry shifts and upcoming opportunities.<br />\r\n✅ Actionable strategies to stay ahead of the curve.<br />\r\n🎯 A quick, powerful read to boost your decision-making.</p>\r\n', 'https://chsculture.org/wp-content/uploads/2021/12/Newsletter.png', 'https://youtube.com/shorts/n2J2fJy2GRM?si=vZ9NvtKDpniGVq2R', NULL, '{\"this_weeks_insights\":{\"label\":\"This Week\\u2019s Insights\",\"category_id\":1,\"subcategory\":\"this week v1\",\"content\":\"<p><strong>This Week&rsquo;s Insights</strong></p>\\r\\n\\r\\n<p>\\ud83d\\ude80 Fresh Perspectives for Your Week<br />\\r\\n\\u2705 Discover trending topics shaping tech and business.<br />\\r\\n\\u2705 Deep dives into industry shifts and upcoming opportunities.<br />\\r\\n\\u2705 Actionable strategies to stay ahead of the curve.<br />\\r\\n\\ud83c\\udfaf A quick, powerful read to boost your decision-making.</p>\\r\\n\",\"post_id\":5,\"post_url\":\"http://localhost/shahidkapoor/public/post.php?id=5\"},\"quick_bytes\":{\"label\":\"Quick Bytes\",\"category_id\":2,\"subcategory\":\"quick v1\",\"content\":\"<p><strong>Quick Bytes</strong></p>\\r\\n\\r\\n<p>\\u26a1 Small Nuggets, Big Impact<br />\\r\\n\\u2705 Bite-sized tips on productivity, learning, and tools.<br />\\r\\n\\u2705 Curated links \\ud83d\\udd17 to must-read articles and resources.<br />\\r\\n\\u2705 Fast facts \\ud83d\\udcca to stay informed without information overload.<br />\\r\\n\\ud83d\\udccc Perfect for a 2-minute coffee break update.</p>\\r\\n\",\"post_id\":3,\"post_url\":\"http://localhost/shahidkapoor/public/post.php?id=3\"},\"ai_tip\":{\"label\":\"AI Tip of the Week\",\"category_id\":3,\"subcategory\":\"ai v1\",\"content\":\"<p><strong>AI Tip of the Week</strong></p>\\r\\n\\r\\n<p>\\ud83e\\udd16 Unlock AI&rsquo;s Potential<br />\\r\\n\\u2705 Practical advice for using AI tools effectively.<br />\\r\\n\\u2705 How to automate small tasks and save time.<br />\\r\\n\\u2705 Quick demonstrations for beginners and pros.<br />\\r\\n\\ud83d\\udd52 Boost efficiency with smart AI shortcuts.</p>\\r\\n\",\"post_id\":1,\"post_url\":\"http://localhost/shahidkapoor/public/post.php?id=1\"},\"toolbox\":{\"label\":\"Toolbox\",\"category_id\":4,\"subcategory\":\"toolbox v1\",\"content\":\"<p><strong>Toolbox</strong></p>\\r\\n\\r\\n<ul>\\r\\n\\t<li>\\ud83d\\udee0 Your Go-To Resource Hub</li>\\r\\n\\t<li>\\u2705 Highlighted apps, plugins, and frameworks worth trying.</li>\\r\\n\\t<li>\\u2705 Step-by-step guidance for setup or best practices.</li>\\r\\n\\t<li>\\u2705 Tested recommendations that improve workflow.</li>\\r\\n\\t<li>\\ud83d\\udccc Keep this section handy for future projects.</li>\\r\\n</ul>\\r\\n\",\"post_id\":6,\"post_url\":\"http://localhost/shahidkapoor/public/post.php?id=6\"},\"market_news\":{\"label\":\"Market News\",\"category_id\":5,\"subcategory\":\"market v1\",\"content\":\"<p><strong>Market News</strong></p>\\r\\n\\r\\n<ol>\\r\\n\\t<li>\\ud83d\\udcc8 Stay Ahead of the Trends</li>\\r\\n\\t<li>\\u2705 Key updates from finance, startups, and technology.</li>\\r\\n\\t<li>\\u2705 Simplified analysis for quick understanding.</li>\\r\\n\\t<li>\\u2705 Charts \\ud83d\\udcca and snapshots that reveal the bigger picture.</li>\\r\\n\\t<li>\\ud83c\\udfaf Stay informed to make smarter moves.</li>\\r\\n</ol>\\r\\n\",\"post_id\":2,\"post_url\":\"http://localhost/shahidkapoor/public/post.php?id=2\"},\"wellnessbyte\":{\"label\":\"Wellnessbyte\",\"category_id\":6,\"subcategory\":\"well v1\",\"content\":\"<p><strong>Wellnessbyte</strong></p>\\r\\n\\r\\n<p>\\ud83c\\udf31 Balance Work and Well-Being<br />\\r\\n\\u2705 Simple tips for mental clarity and focus.<br />\\r\\n\\u2705 Quick exercises or mindfulness hacks \\ud83e\\uddd8.<br />\\r\\n\\u2705 Nutrition and lifestyle pointers for busy professionals.<br />\\r\\n\\ud83d\\udd52 Small actions, big long-term benefits.</p>\\r\\n\",\"post_id\":7,\"post_url\":\"http://localhost/shahidkapoor/public/post.php?id=7\"},\"quote_of_the_day\":{\"label\":\"Quote of the Day\",\"category_id\":7,\"subcategory\":\"quote v1\",\"content\":\"<p><strong>Quote of the Day</strong></p>\\r\\n\\r\\n<p>\\ud83d\\udca1 Inspiration to Power Your Day<br />\\r\\n\\u2705 A thought-provoking quote to spark creativity.<br />\\r\\n\\u2705 A one-line reflection or takeaway.<br />\\r\\n\\ud83d\\udccc Use it as your mantra or share with your team.<br />\\r\\n\\ud83c\\udfaf A little wisdom to keep your motivation high.</p>\\r\\n\",\"post_id\":4,\"post_url\":\"http://localhost/shahidkapoor/public/post.php?id=4\"}}', '2025-09-13 10:37:10', '2025-09-13 10:37:22', NULL, 'sent');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_date` date DEFAULT curdate(),
  `author_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_media` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`links`)),
  `component_id` int(11) DEFAULT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `description`, `post_date`, `author_id`, `category_id`, `subcategory`, `main_media`, `links`, `component_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'ai', '<h3><strong>This This Week Insights &nbsp;saturday volumn 11</strong></h3>\r\n\r\n<p>🚀&nbsp;<strong>Fresh Perspectives for Your Week</strong></p>\r\n\r\n<p>In today&rsquo;s fast-moving world, staying ahead means understanding the shifts that drive technology, business, and innovation.&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;is your trusted source for decoding these changes and turning information into opportunity. Each edition is carefully curated to bring you meaningful updates and strategies you can act on right away.</p>\r\n\r\n<p><strong>📈 Stay Ahead of the Trends</strong></p>\r\n\r\n<ul>\r\n	<li>✅ Key updates from finance, startups, and technology.</li>\r\n	<li>✅ Simplified analysis for quick understanding.</li>\r\n	<li>✅ Charts 📊 and snapshots that reveal the bigger picture.</li>\r\n	<li>🎯 Stay informed to make smarter moves.</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Discover Emerging Trends Shaping Industries Worldwide</strong><br />\r\nFrom breakthrough artificial intelligence models and revolutionary software tools to surprising market moves by startups, innovation is happening at lightning speed. This section filters through the noise to highlight the developments that matter most. Whether it&rsquo;s a new AI-powered design platform changing the creative industry or a funding trend reshaping the startup ecosystem, you&rsquo;ll always be in the know.</p>\r\n\r\n<p><strong>Quick Bytes</strong></p>\r\n\r\n<ol>\r\n	<li>⚡ Small Nuggets, Big&nbsp;<a href=\"https://manus.im/\" target=\"_blank\">manus ai</a></li>\r\n	<li>✅ Bite-sized tips on productivity, learning, and tools.</li>\r\n	<li>✅ Curated links 🔗 to must-read articles and resources.</li>\r\n	<li>✅ Fast facts 📊 to stay informed without information overload.</li>\r\n	<li>📌 Perfect for a 2-minute coffee break update.</li>\r\n</ol>\r\n\r\n<p>✅&nbsp;<strong>Deep-Dive Analyses for Smarter Decisions</strong><br />\r\nWe go beyond surface-level headlines to unpack what&rsquo;s really happening. Why are venture capital investments shifting toward sustainable tech? What does the latest government policy mean for data privacy or fintech regulation? These insights give you the foresight to anticipate opportunities and challenges before they fully emerge.</p>\r\n\r\n<p><br />\r\n<strong>AI Tip of the Week</strong></p>\r\n\r\n<ul>\r\n	<li>🤖 Unlock AI&rsquo;s&nbsp;<a href=\"https://gemini.google.com/app\" target=\"_blank\">gemini ai</a></li>\r\n	<li>✅ Practical advice for using AI tools effectively.</li>\r\n	<li>✅ How to automate small tasks and save time.</li>\r\n	<li>✅ Quick demonstrations for beginners and pros.</li>\r\n	<li>🕒 Boost efficiency with smart AI shortcuts.&nbsp;</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Actionable Strategies and Growth Hacks</strong><br />\r\nInformation alone isn&rsquo;t enough&mdash;you need practical steps you can take. Every piece of analysis includes clear, actionable strategies. Whether you&rsquo;re a developer adopting a new framework, an entrepreneur exploring a pivot, or a professional seeking an edge in your career, you&rsquo;ll find advice tailored to your context.</p>\r\n\r\n<p>🎯&nbsp;<strong>Your Mini Playbook for the Week Ahead</strong><br />\r\nThink of&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;as a powerful yet quick read&mdash;something you can absorb over your morning coffee but rely on throughout the week. It&rsquo;s like having a personal strategist in your inbox: guiding you through shifting markets, emerging technologies, and business opportunities. The aim isn&rsquo;t just to inform&mdash;it&rsquo;s to equip you with the clarity and confidence to act decisively.</p>\r\n\r\n<p>By the end of each week, you won&rsquo;t just know what&rsquo;s trending&mdash;you&rsquo;ll understand&nbsp;<em>why it matters</em>&nbsp;and how to position yourself ahead of the curve. Whether you&rsquo;re steering a team, running a startup, or building your personal skill set, these insights will become an essential part of your decision-making toolkit.</p>\r\n', '2025-09-13', 1, 3, 'ai v1', '1757759553_image1.jpg', NULL, NULL, 'published', '2025-09-13 10:32:33', NULL),
(2, 'market ', '<h3><strong>This This Week Insights &nbsp;saturday volumn 11</strong></h3>\r\n\r\n<p>🚀&nbsp;<strong>Fresh Perspectives for Your Week</strong></p>\r\n\r\n<p>In today&rsquo;s fast-moving world, staying ahead means understanding the shifts that drive technology, business, and innovation.&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;is your trusted source for decoding these changes and turning information into opportunity. Each edition is carefully curated to bring you meaningful updates and strategies you can act on right away.</p>\r\n\r\n<p><strong>📈 Stay Ahead of the Trends</strong></p>\r\n\r\n<ul>\r\n	<li>✅ Key updates from finance, startups, and technology.</li>\r\n	<li>✅ Simplified analysis for quick understanding.</li>\r\n	<li>✅ Charts 📊 and snapshots that reveal the bigger picture.</li>\r\n	<li>🎯 Stay informed to make smarter moves.</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Discover Emerging Trends Shaping Industries Worldwide</strong><br />\r\nFrom breakthrough artificial intelligence models and revolutionary software tools to surprising market moves by startups, innovation is happening at lightning speed. This section filters through the noise to highlight the developments that matter most. Whether it&rsquo;s a new AI-powered design platform changing the creative industry or a funding trend reshaping the startup ecosystem, you&rsquo;ll always be in the know.</p>\r\n\r\n<p><strong>Quick Bytes</strong></p>\r\n\r\n<ol>\r\n	<li>⚡ Small Nuggets, Big&nbsp;<a href=\"https://manus.im/\" target=\"_blank\">manus ai</a></li>\r\n	<li>✅ Bite-sized tips on productivity, learning, and tools.</li>\r\n	<li>✅ Curated links 🔗 to must-read articles and resources.</li>\r\n	<li>✅ Fast facts 📊 to stay informed without information overload.</li>\r\n	<li>📌 Perfect for a 2-minute coffee break update.</li>\r\n</ol>\r\n\r\n<p>✅&nbsp;<strong>Deep-Dive Analyses for Smarter Decisions</strong><br />\r\nWe go beyond surface-level headlines to unpack what&rsquo;s really happening. Why are venture capital investments shifting toward sustainable tech? What does the latest government policy mean for data privacy or fintech regulation? These insights give you the foresight to anticipate opportunities and challenges before they fully emerge.</p>\r\n\r\n<p><br />\r\n<strong>AI Tip of the Week</strong></p>\r\n\r\n<ul>\r\n	<li>🤖 Unlock AI&rsquo;s&nbsp;<a href=\"https://gemini.google.com/app\" target=\"_blank\">gemini ai</a></li>\r\n	<li>✅ Practical advice for using AI tools effectively.</li>\r\n	<li>✅ How to automate small tasks and save time.</li>\r\n	<li>✅ Quick demonstrations for beginners and pros.</li>\r\n	<li>🕒 Boost efficiency with smart AI shortcuts.&nbsp;</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Actionable Strategies and Growth Hacks</strong><br />\r\nInformation alone isn&rsquo;t enough&mdash;you need practical steps you can take. Every piece of analysis includes clear, actionable strategies. Whether you&rsquo;re a developer adopting a new framework, an entrepreneur exploring a pivot, or a professional seeking an edge in your career, you&rsquo;ll find advice tailored to your context.</p>\r\n\r\n<p>🎯&nbsp;<strong>Your Mini Playbook for the Week Ahead</strong><br />\r\nThink of&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;as a powerful yet quick read&mdash;something you can absorb over your morning coffee but rely on throughout the week. It&rsquo;s like having a personal strategist in your inbox: guiding you through shifting markets, emerging technologies, and business opportunities. The aim isn&rsquo;t just to inform&mdash;it&rsquo;s to equip you with the clarity and confidence to act decisively.</p>\r\n\r\n<p>By the end of each week, you won&rsquo;t just know what&rsquo;s trending&mdash;you&rsquo;ll understand&nbsp;<em>why it matters</em>&nbsp;and how to position yourself ahead of the curve. Whether you&rsquo;re steering a team, running a startup, or building your personal skill set, these insights will become an essential part of your decision-making toolkit.</p>\r\n', '2025-09-13', 1, 5, 'market v1', '1757759576_image2.jpg', NULL, NULL, 'published', '2025-09-13 10:32:56', NULL),
(3, 'quick', '<h3><strong>This This Week Insights &nbsp;saturday volumn 11</strong></h3>\r\n\r\n<p>🚀&nbsp;<strong>Fresh Perspectives for Your Week</strong></p>\r\n\r\n<p>In today&rsquo;s fast-moving world, staying ahead means understanding the shifts that drive technology, business, and innovation.&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;is your trusted source for decoding these changes and turning information into opportunity. Each edition is carefully curated to bring you meaningful updates and strategies you can act on right away.</p>\r\n\r\n<p><strong>📈 Stay Ahead of the Trends</strong></p>\r\n\r\n<ul>\r\n	<li>✅ Key updates from finance, startups, and technology.</li>\r\n	<li>✅ Simplified analysis for quick understanding.</li>\r\n	<li>✅ Charts 📊 and snapshots that reveal the bigger picture.</li>\r\n	<li>🎯 Stay informed to make smarter moves.</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Discover Emerging Trends Shaping Industries Worldwide</strong><br />\r\nFrom breakthrough artificial intelligence models and revolutionary software tools to surprising market moves by startups, innovation is happening at lightning speed. This section filters through the noise to highlight the developments that matter most. Whether it&rsquo;s a new AI-powered design platform changing the creative industry or a funding trend reshaping the startup ecosystem, you&rsquo;ll always be in the know.</p>\r\n\r\n<p><strong>Quick Bytes</strong></p>\r\n\r\n<ol>\r\n	<li>⚡ Small Nuggets, Big&nbsp;<a href=\"https://manus.im/\" target=\"_blank\">manus ai</a></li>\r\n	<li>✅ Bite-sized tips on productivity, learning, and tools.</li>\r\n	<li>✅ Curated links 🔗 to must-read articles and resources.</li>\r\n	<li>✅ Fast facts 📊 to stay informed without information overload.</li>\r\n	<li>📌 Perfect for a 2-minute coffee break update.</li>\r\n</ol>\r\n\r\n<p>✅&nbsp;<strong>Deep-Dive Analyses for Smarter Decisions</strong><br />\r\nWe go beyond surface-level headlines to unpack what&rsquo;s really happening. Why are venture capital investments shifting toward sustainable tech? What does the latest government policy mean for data privacy or fintech regulation? These insights give you the foresight to anticipate opportunities and challenges before they fully emerge.</p>\r\n\r\n<p><br />\r\n<strong>AI Tip of the Week</strong></p>\r\n\r\n<ul>\r\n	<li>🤖 Unlock AI&rsquo;s&nbsp;<a href=\"https://gemini.google.com/app\" target=\"_blank\">gemini ai</a></li>\r\n	<li>✅ Practical advice for using AI tools effectively.</li>\r\n	<li>✅ How to automate small tasks and save time.</li>\r\n	<li>✅ Quick demonstrations for beginners and pros.</li>\r\n	<li>🕒 Boost efficiency with smart AI shortcuts.&nbsp;</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Actionable Strategies and Growth Hacks</strong><br />\r\nInformation alone isn&rsquo;t enough&mdash;you need practical steps you can take. Every piece of analysis includes clear, actionable strategies. Whether you&rsquo;re a developer adopting a new framework, an entrepreneur exploring a pivot, or a professional seeking an edge in your career, you&rsquo;ll find advice tailored to your context.</p>\r\n\r\n<p>🎯&nbsp;<strong>Your Mini Playbook for the Week Ahead</strong><br />\r\nThink of&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;as a powerful yet quick read&mdash;something you can absorb over your morning coffee but rely on throughout the week. It&rsquo;s like having a personal strategist in your inbox: guiding you through shifting markets, emerging technologies, and business opportunities. The aim isn&rsquo;t just to inform&mdash;it&rsquo;s to equip you with the clarity and confidence to act decisively.</p>\r\n\r\n<p>By the end of each week, you won&rsquo;t just know what&rsquo;s trending&mdash;you&rsquo;ll understand&nbsp;<em>why it matters</em>&nbsp;and how to position yourself ahead of the curve. Whether you&rsquo;re steering a team, running a startup, or building your personal skill set, these insights will become an essential part of your decision-making toolkit.</p>\r\n', '2025-09-13', 1, 2, 'quick v1', '1757759595_image3.jpg', NULL, NULL, 'published', '2025-09-13 10:33:15', NULL),
(4, 'quote ', '<h3><strong>This This Week Insights &nbsp;saturday volumn 11</strong></h3>\r\n\r\n<p>🚀&nbsp;<strong>Fresh Perspectives for Your Week</strong></p>\r\n\r\n<p>In today&rsquo;s fast-moving world, staying ahead means understanding the shifts that drive technology, business, and innovation.&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;is your trusted source for decoding these changes and turning information into opportunity. Each edition is carefully curated to bring you meaningful updates and strategies you can act on right away.</p>\r\n\r\n<p><strong>📈 Stay Ahead of the Trends</strong></p>\r\n\r\n<ul>\r\n	<li>✅ Key updates from finance, startups, and technology.</li>\r\n	<li>✅ Simplified analysis for quick understanding.</li>\r\n	<li>✅ Charts 📊 and snapshots that reveal the bigger picture.</li>\r\n	<li>🎯 Stay informed to make smarter moves.</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Discover Emerging Trends Shaping Industries Worldwide</strong><br />\r\nFrom breakthrough artificial intelligence models and revolutionary software tools to surprising market moves by startups, innovation is happening at lightning speed. This section filters through the noise to highlight the developments that matter most. Whether it&rsquo;s a new AI-powered design platform changing the creative industry or a funding trend reshaping the startup ecosystem, you&rsquo;ll always be in the know.</p>\r\n\r\n<p><strong>Quick Bytes</strong></p>\r\n\r\n<ol>\r\n	<li>⚡ Small Nuggets, Big&nbsp;<a href=\"https://manus.im/\" target=\"_blank\">manus ai</a></li>\r\n	<li>✅ Bite-sized tips on productivity, learning, and tools.</li>\r\n	<li>✅ Curated links 🔗 to must-read articles and resources.</li>\r\n	<li>✅ Fast facts 📊 to stay informed without information overload.</li>\r\n	<li>📌 Perfect for a 2-minute coffee break update.</li>\r\n</ol>\r\n\r\n<p>✅&nbsp;<strong>Deep-Dive Analyses for Smarter Decisions</strong><br />\r\nWe go beyond surface-level headlines to unpack what&rsquo;s really happening. Why are venture capital investments shifting toward sustainable tech? What does the latest government policy mean for data privacy or fintech regulation? These insights give you the foresight to anticipate opportunities and challenges before they fully emerge.</p>\r\n\r\n<p><br />\r\n<strong>AI Tip of the Week</strong></p>\r\n\r\n<ul>\r\n	<li>🤖 Unlock AI&rsquo;s&nbsp;<a href=\"https://gemini.google.com/app\" target=\"_blank\">gemini ai</a></li>\r\n	<li>✅ Practical advice for using AI tools effectively.</li>\r\n	<li>✅ How to automate small tasks and save time.</li>\r\n	<li>✅ Quick demonstrations for beginners and pros.</li>\r\n	<li>🕒 Boost efficiency with smart AI shortcuts.&nbsp;</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Actionable Strategies and Growth Hacks</strong><br />\r\nInformation alone isn&rsquo;t enough&mdash;you need practical steps you can take. Every piece of analysis includes clear, actionable strategies. Whether you&rsquo;re a developer adopting a new framework, an entrepreneur exploring a pivot, or a professional seeking an edge in your career, you&rsquo;ll find advice tailored to your context.</p>\r\n\r\n<p>🎯&nbsp;<strong>Your Mini Playbook for the Week Ahead</strong><br />\r\nThink of&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;as a powerful yet quick read&mdash;something you can absorb over your morning coffee but rely on throughout the week. It&rsquo;s like having a personal strategist in your inbox: guiding you through shifting markets, emerging technologies, and business opportunities. The aim isn&rsquo;t just to inform&mdash;it&rsquo;s to equip you with the clarity and confidence to act decisively.</p>\r\n\r\n<p>By the end of each week, you won&rsquo;t just know what&rsquo;s trending&mdash;you&rsquo;ll understand&nbsp;<em>why it matters</em>&nbsp;and how to position yourself ahead of the curve. Whether you&rsquo;re steering a team, running a startup, or building your personal skill set, these insights will become an essential part of your decision-making toolkit.</p>\r\n', '2025-09-13', 1, 7, 'quote v1', '1757759615_image1.jpg', NULL, NULL, 'published', '2025-09-13 10:33:35', NULL),
(5, 'this week', '<h3><strong>This This Week Insights &nbsp;saturday volumn 11</strong></h3>\r\n\r\n<p>🚀&nbsp;<strong>Fresh Perspectives for Your Week</strong></p>\r\n\r\n<p>In today&rsquo;s fast-moving world, staying ahead means understanding the shifts that drive technology, business, and innovation.&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;is your trusted source for decoding these changes and turning information into opportunity. Each edition is carefully curated to bring you meaningful updates and strategies you can act on right away.</p>\r\n\r\n<p><strong>📈 Stay Ahead of the Trends</strong></p>\r\n\r\n<ul>\r\n	<li>✅ Key updates from finance, startups, and technology.</li>\r\n	<li>✅ Simplified analysis for quick understanding.</li>\r\n	<li>✅ Charts 📊 and snapshots that reveal the bigger picture.</li>\r\n	<li>🎯 Stay informed to make smarter moves.</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Discover Emerging Trends Shaping Industries Worldwide</strong><br />\r\nFrom breakthrough artificial intelligence models and revolutionary software tools to surprising market moves by startups, innovation is happening at lightning speed. This section filters through the noise to highlight the developments that matter most. Whether it&rsquo;s a new AI-powered design platform changing the creative industry or a funding trend reshaping the startup ecosystem, you&rsquo;ll always be in the know.</p>\r\n\r\n<p><strong>Quick Bytes</strong></p>\r\n\r\n<ol>\r\n	<li>⚡ Small Nuggets, Big&nbsp;<a href=\"https://manus.im/\" target=\"_blank\">manus ai</a></li>\r\n	<li>✅ Bite-sized tips on productivity, learning, and tools.</li>\r\n	<li>✅ Curated links 🔗 to must-read articles and resources.</li>\r\n	<li>✅ Fast facts 📊 to stay informed without information overload.</li>\r\n	<li>📌 Perfect for a 2-minute coffee break update.</li>\r\n</ol>\r\n\r\n<p>✅&nbsp;<strong>Deep-Dive Analyses for Smarter Decisions</strong><br />\r\nWe go beyond surface-level headlines to unpack what&rsquo;s really happening. Why are venture capital investments shifting toward sustainable tech? What does the latest government policy mean for data privacy or fintech regulation? These insights give you the foresight to anticipate opportunities and challenges before they fully emerge.</p>\r\n\r\n<p><br />\r\n<strong>AI Tip of the Week</strong></p>\r\n\r\n<ul>\r\n	<li>🤖 Unlock AI&rsquo;s&nbsp;<a href=\"https://gemini.google.com/app\" target=\"_blank\">gemini ai</a></li>\r\n	<li>✅ Practical advice for using AI tools effectively.</li>\r\n	<li>✅ How to automate small tasks and save time.</li>\r\n	<li>✅ Quick demonstrations for beginners and pros.</li>\r\n	<li>🕒 Boost efficiency with smart AI shortcuts.&nbsp;</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Actionable Strategies and Growth Hacks</strong><br />\r\nInformation alone isn&rsquo;t enough&mdash;you need practical steps you can take. Every piece of analysis includes clear, actionable strategies. Whether you&rsquo;re a developer adopting a new framework, an entrepreneur exploring a pivot, or a professional seeking an edge in your career, you&rsquo;ll find advice tailored to your context.</p>\r\n\r\n<p>🎯&nbsp;<strong>Your Mini Playbook for the Week Ahead</strong><br />\r\nThink of&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;as a powerful yet quick read&mdash;something you can absorb over your morning coffee but rely on throughout the week. It&rsquo;s like having a personal strategist in your inbox: guiding you through shifting markets, emerging technologies, and business opportunities. The aim isn&rsquo;t just to inform&mdash;it&rsquo;s to equip you with the clarity and confidence to act decisively.</p>\r\n\r\n<p>By the end of each week, you won&rsquo;t just know what&rsquo;s trending&mdash;you&rsquo;ll understand&nbsp;<em>why it matters</em>&nbsp;and how to position yourself ahead of the curve. Whether you&rsquo;re steering a team, running a startup, or building your personal skill set, these insights will become an essential part of your decision-making toolkit.</p>\r\n', '2025-09-13', 1, 1, 'this week v1', '1757759635_image1.jpg', NULL, NULL, 'published', '2025-09-13 10:33:55', NULL),
(6, 'toolbox', '<h3><strong>This This Week Insights &nbsp;saturday volumn 11</strong></h3>\r\n\r\n<p>🚀&nbsp;<strong>Fresh Perspectives for Your Week</strong></p>\r\n\r\n<p>In today&rsquo;s fast-moving world, staying ahead means understanding the shifts that drive technology, business, and innovation.&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;is your trusted source for decoding these changes and turning information into opportunity. Each edition is carefully curated to bring you meaningful updates and strategies you can act on right away.</p>\r\n\r\n<p><strong>📈 Stay Ahead of the Trends</strong></p>\r\n\r\n<ul>\r\n	<li>✅ Key updates from finance, startups, and technology.</li>\r\n	<li>✅ Simplified analysis for quick understanding.</li>\r\n	<li>✅ Charts 📊 and snapshots that reveal the bigger picture.</li>\r\n	<li>🎯 Stay informed to make smarter moves.</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Discover Emerging Trends Shaping Industries Worldwide</strong><br />\r\nFrom breakthrough artificial intelligence models and revolutionary software tools to surprising market moves by startups, innovation is happening at lightning speed. This section filters through the noise to highlight the developments that matter most. Whether it&rsquo;s a new AI-powered design platform changing the creative industry or a funding trend reshaping the startup ecosystem, you&rsquo;ll always be in the know.</p>\r\n\r\n<p><strong>Quick Bytes</strong></p>\r\n\r\n<ol>\r\n	<li>⚡ Small Nuggets, Big&nbsp;<a href=\"https://manus.im/\" target=\"_blank\">manus ai</a></li>\r\n	<li>✅ Bite-sized tips on productivity, learning, and tools.</li>\r\n	<li>✅ Curated links 🔗 to must-read articles and resources.</li>\r\n	<li>✅ Fast facts 📊 to stay informed without information overload.</li>\r\n	<li>📌 Perfect for a 2-minute coffee break update.</li>\r\n</ol>\r\n\r\n<p>✅&nbsp;<strong>Deep-Dive Analyses for Smarter Decisions</strong><br />\r\nWe go beyond surface-level headlines to unpack what&rsquo;s really happening. Why are venture capital investments shifting toward sustainable tech? What does the latest government policy mean for data privacy or fintech regulation? These insights give you the foresight to anticipate opportunities and challenges before they fully emerge.</p>\r\n\r\n<p><br />\r\n<strong>AI Tip of the Week</strong></p>\r\n\r\n<ul>\r\n	<li>🤖 Unlock AI&rsquo;s&nbsp;<a href=\"https://gemini.google.com/app\" target=\"_blank\">gemini ai</a></li>\r\n	<li>✅ Practical advice for using AI tools effectively.</li>\r\n	<li>✅ How to automate small tasks and save time.</li>\r\n	<li>✅ Quick demonstrations for beginners and pros.</li>\r\n	<li>🕒 Boost efficiency with smart AI shortcuts.&nbsp;</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Actionable Strategies and Growth Hacks</strong><br />\r\nInformation alone isn&rsquo;t enough&mdash;you need practical steps you can take. Every piece of analysis includes clear, actionable strategies. Whether you&rsquo;re a developer adopting a new framework, an entrepreneur exploring a pivot, or a professional seeking an edge in your career, you&rsquo;ll find advice tailored to your context.</p>\r\n\r\n<p>🎯&nbsp;<strong>Your Mini Playbook for the Week Ahead</strong><br />\r\nThink of&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;as a powerful yet quick read&mdash;something you can absorb over your morning coffee but rely on throughout the week. It&rsquo;s like having a personal strategist in your inbox: guiding you through shifting markets, emerging technologies, and business opportunities. The aim isn&rsquo;t just to inform&mdash;it&rsquo;s to equip you with the clarity and confidence to act decisively.</p>\r\n\r\n<p>By the end of each week, you won&rsquo;t just know what&rsquo;s trending&mdash;you&rsquo;ll understand&nbsp;<em>why it matters</em>&nbsp;and how to position yourself ahead of the curve. Whether you&rsquo;re steering a team, running a startup, or building your personal skill set, these insights will become an essential part of your decision-making toolkit.</p>\r\n', '2025-09-13', 1, 4, 'toolbox v1', '1757759654_image1.jpg', NULL, NULL, 'published', '2025-09-13 10:34:14', NULL),
(7, 'well', '<h3><strong>This This Week Insights &nbsp;saturday volumn 11</strong></h3>\r\n\r\n<p>🚀&nbsp;<strong>Fresh Perspectives for Your Week</strong></p>\r\n\r\n<p>In today&rsquo;s fast-moving world, staying ahead means understanding the shifts that drive technology, business, and innovation.&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;is your trusted source for decoding these changes and turning information into opportunity. Each edition is carefully curated to bring you meaningful updates and strategies you can act on right away.</p>\r\n\r\n<p><strong>📈 Stay Ahead of the Trends</strong></p>\r\n\r\n<ul>\r\n	<li>✅ Key updates from finance, startups, and technology.</li>\r\n	<li>✅ Simplified analysis for quick understanding.</li>\r\n	<li>✅ Charts 📊 and snapshots that reveal the bigger picture.</li>\r\n	<li>🎯 Stay informed to make smarter moves.</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Discover Emerging Trends Shaping Industries Worldwide</strong><br />\r\nFrom breakthrough artificial intelligence models and revolutionary software tools to surprising market moves by startups, innovation is happening at lightning speed. This section filters through the noise to highlight the developments that matter most. Whether it&rsquo;s a new AI-powered design platform changing the creative industry or a funding trend reshaping the startup ecosystem, you&rsquo;ll always be in the know.</p>\r\n\r\n<p><strong>Quick Bytes</strong></p>\r\n\r\n<ol>\r\n	<li>⚡ Small Nuggets, Big&nbsp;<a href=\"https://manus.im/\" target=\"_blank\">manus ai</a></li>\r\n	<li>✅ Bite-sized tips on productivity, learning, and tools.</li>\r\n	<li>✅ Curated links 🔗 to must-read articles and resources.</li>\r\n	<li>✅ Fast facts 📊 to stay informed without information overload.</li>\r\n	<li>📌 Perfect for a 2-minute coffee break update.</li>\r\n</ol>\r\n\r\n<p>✅&nbsp;<strong>Deep-Dive Analyses for Smarter Decisions</strong><br />\r\nWe go beyond surface-level headlines to unpack what&rsquo;s really happening. Why are venture capital investments shifting toward sustainable tech? What does the latest government policy mean for data privacy or fintech regulation? These insights give you the foresight to anticipate opportunities and challenges before they fully emerge.</p>\r\n\r\n<p><br />\r\n<strong>AI Tip of the Week</strong></p>\r\n\r\n<ul>\r\n	<li>🤖 Unlock AI&rsquo;s&nbsp;<a href=\"https://gemini.google.com/app\" target=\"_blank\">gemini ai</a></li>\r\n	<li>✅ Practical advice for using AI tools effectively.</li>\r\n	<li>✅ How to automate small tasks and save time.</li>\r\n	<li>✅ Quick demonstrations for beginners and pros.</li>\r\n	<li>🕒 Boost efficiency with smart AI shortcuts.&nbsp;</li>\r\n</ul>\r\n\r\n<p>✅&nbsp;<strong>Actionable Strategies and Growth Hacks</strong><br />\r\nInformation alone isn&rsquo;t enough&mdash;you need practical steps you can take. Every piece of analysis includes clear, actionable strategies. Whether you&rsquo;re a developer adopting a new framework, an entrepreneur exploring a pivot, or a professional seeking an edge in your career, you&rsquo;ll find advice tailored to your context.</p>\r\n\r\n<p>🎯&nbsp;<strong>Your Mini Playbook for the Week Ahead</strong><br />\r\nThink of&nbsp;<em>This Week&rsquo;s Insights</em>&nbsp;as a powerful yet quick read&mdash;something you can absorb over your morning coffee but rely on throughout the week. It&rsquo;s like having a personal strategist in your inbox: guiding you through shifting markets, emerging technologies, and business opportunities. The aim isn&rsquo;t just to inform&mdash;it&rsquo;s to equip you with the clarity and confidence to act decisively.</p>\r\n\r\n<p>By the end of each week, you won&rsquo;t just know what&rsquo;s trending&mdash;you&rsquo;ll understand&nbsp;<em>why it matters</em>&nbsp;and how to position yourself ahead of the curve. Whether you&rsquo;re steering a team, running a startup, or building your personal skill set, these insights will become an essential part of your decision-making toolkit.</p>\r\n', '2025-09-13', 1, 6, 'well v1', '1757759670_image2.jpg', NULL, NULL, 'published', '2025-09-13 10:34:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  ADD KEY `fk_nl_category` (`category_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `newsletter_master`
--
ALTER TABLE `newsletter_master`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
