-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- Généré le : Mercredi 06 Décembre 2006 à 16:46
-- Version du serveur: 4.1.9
-- Version de PHP: 4.4.4
-- 
-- Base de données: `chat`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `history`
-- 

CREATE TABLE `history` (
  `id` int(11) NOT NULL auto_increment,
  `nick` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;
        