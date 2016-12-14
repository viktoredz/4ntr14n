

DROP TABLE IF EXISTS `app_files`;
CREATE TABLE `app_files` (
  `id` int(10) NOT NULL,
  `lang` varchar(10) NOT NULL DEFAULT 'ina',
  `filename` varchar(100) NOT NULL,
  `module` varchar(100) DEFAULT NULL,
  `id_theme` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_files`
--

INSERT INTO `app_files` (`id`, `lang`, `filename`, `module`, `id_theme`) VALUES
(1, 'ina', 'Home', 'morganisasi', 2),
(2, 'en', 'Users', 'admin_user', 2),
(6, 'ina', 'Master Data', '#', 2),
(6, 'en', 'Master Data', '#', 2),
(2, 'ina', 'Users', 'admin_user', 2),
(1, 'en', 'Home', 'index.php', 2),
(31, 'ina', 'Admin', 'admin', 3),
(31, 'en', 'Admin', 'admin', 3),
(36, 'ina', 'Menu', 'admin_menu', 2),
(36, 'en', 'Menu', 'admin_menu', 2),
(37, 'ina', 'File', 'admin_file', 2),
(37, 'en', 'Files', 'admin_file', 2),
(38, 'ina', 'Hak Akses', 'admin_role', 2),
(38, 'en', 'Role', 'admin_role', 2),
(39, 'ina', 'Dashboard', '#', 2),
(39, 'en', 'Dashboard', '#', 2),
(40, 'ina', 'Profil', 'morganisasi/profile', 2),
(40, 'en', 'Profile', 'morganisasi/profile', 2),
(49, 'ina', 'Admin Panel', '#', 2),
(49, 'en', 'Admin Panel', '#', 2),
(51, 'ina', 'Data Master', '#', 2),
(51, 'en', 'Master Data', '#', 2),
(79, 'ina', 'mst', 'mst', 2),
(79, 'en', 'mst', 'mst', 2),
(4, 'en', 'Video', 'video', 2),
(5, 'ina', 'Antrian', 'antrian', 2),
(5, 'en', 'Antrian', 'antrian', 2),
(7, 'ina', 'Data Pasien', 'antrian/pasien', 2),
(7, 'en', 'Data Pasien', 'antrian/pasien', 2),
(3, 'ina', 'Pengumuman', 'news', 2),
(3, 'en', 'Pengumuman', 'news', 2),
(4, 'ina', 'Video', 'video', 2),
(165, 'ina', 'Poli', 'poli', 2),
(165, 'en', 'Poli', 'poli', 2);

-- --------------------------------------------------------

--
-- Table structure for table `app_menus`
--

DROP TABLE IF EXISTS `app_menus`;
CREATE TABLE `app_menus` (
  `position` int(10) NOT NULL,
  `id` int(10) NOT NULL,
  `sub_id` int(10) NOT NULL DEFAULT '0',
  `sort` int(10) NOT NULL DEFAULT '0',
  `file_id` int(10) NOT NULL,
  `id_theme` int(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_menus`
--

INSERT INTO `app_menus` (`position`, `id`, `sub_id`, `sort`, `file_id`, `id_theme`) VALUES
(1, 2, 1, 0, 1, 2),
(1, 1, 0, 0, 39, 2),
(1, 3, 1, 2, 40, 2),
(1, 19, 0, 3, 49, 2),
(1, 20, 19, 0, 50, 2),
(1, 21, 19, 3, 2, 2),
(1, 22, 19, 4, 37, 2),
(1, 23, 19, 5, 38, 2),
(1, 24, 19, 6, 36, 2),
(1, 29, 19, 1, 4, 2),
(1, 30, 1, 3, 7, 2),
(1, 28, 19, 0, 3, 2),
(1, 31, 19, 2, 165, 2);

-- --------------------------------------------------------

--
-- Table structure for table `app_users_access`
--

DROP TABLE IF EXISTS `app_users_access`;
CREATE TABLE `app_users_access` (
  `file_id` int(10) NOT NULL,
  `level_id` varchar(100) NOT NULL,
  `doshow` int(1) NOT NULL DEFAULT '0',
  `doadd` int(1) NOT NULL DEFAULT '0',
  `doedit` int(1) NOT NULL DEFAULT '0',
  `dodel` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_users_access`
--

INSERT INTO `app_users_access` (`file_id`, `level_id`, `doshow`, `doadd`, `doedit`, `dodel`) VALUES
(1, 'guest', 1, 1, 1, 1),
(79, 'administrator', 1, 1, 1, 1),
(51, 'administrator', 1, 1, 1, 1),
(49, 'administrator', 1, 1, 1, 1),
(40, 'administrator', 1, 1, 1, 1),
(39, 'administrator', 1, 1, 1, 1),
(38, 'administrator', 1, 1, 1, 1),
(37, 'administrator', 1, 1, 1, 1),
(36, 'administrator', 1, 1, 1, 1),
(31, 'administrator', 1, 1, 1, 1),
(7, 'administrator', 1, 1, 1, 1),
(6, 'administrator', 1, 1, 1, 1),
(5, 'administrator', 1, 1, 1, 1),
(4, 'administrator', 1, 1, 1, 1),
(3, 'administrator', 1, 1, 1, 1),
(2, 'administrator', 1, 1, 1, 1),
(1, 'administrator', 1, 1, 1, 1),
(165, 'administrator', 1, 1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_files`
--
ALTER TABLE `app_files`
  ADD PRIMARY KEY (`id`,`lang`);

--
-- Indexes for table `app_menus`
--
ALTER TABLE `app_menus`
  ADD PRIMARY KEY (`position`,`id`),
  ADD KEY `fk_menus_files` (`file_id`);

--
-- Indexes for table `app_users_access`
--
ALTER TABLE `app_users_access`
  ADD PRIMARY KEY (`file_id`,`level_id`),
  ADD KEY `fk_users_access_users_level` (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_files`
--
ALTER TABLE `app_files`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;
