CREATE DATABASE IF NOT EXISTS `indonesia` CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `indonesia`;

CREATE TABLE IF NOT EXISTS `provinsi` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nama` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `kabupaten` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `provinsi_id` int(11) NOT NULL,
    `nama` varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `provinsi_id` (`provinsi_id`),
    FOREIGN KEY (`provinsi_id`) REFERENCES `provinsi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `kecamatan` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `kabupaten_id` int(11) NOT NULL,
    `nama` varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `kabupaten_id` (`kabupaten_id`),
    FOREIGN KEY (`kabupaten_id`) REFERENCES `kabupaten` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `kelurahan` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `kecamatan_id` int(11) NOT NULL,
    `nama` varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `kecamatan_id` (`kecamatan_id`),
    FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
