-- docebo.node_tree definition

CREATE TABLE `node_tree` (
  `idNode` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL,
  `iLeft` int(11) NOT NULL,
  `iRight` int(11) NOT NULL,
  PRIMARY KEY (`idNode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



-- docebo.node_tree_names definition

CREATE TABLE `node_tree_names` (
  `idNode` int(10) unsigned NOT NULL,
  `language` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nodeName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idNode`,`language`),
  CONSTRAINT `node_tree_names_FK` FOREIGN KEY (`idNode`) REFERENCES `node_tree` (`idNode`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
