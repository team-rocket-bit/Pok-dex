-- ----------------------------
-- Table structure for `monsters`
-- ----------------------------
DROP TABLE IF EXISTS `monsters`;
CREATE TABLE `monsters` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type1` varchar(255) NOT NULL,
  `type2` varchar(255) DEFAULT NULL,
  `eggGroups` varchar(255) NOT NULL,
  `genderRatio` double DEFAULT NULL,
  `hatchSteps` int(11) DEFAULT NULL,
  `description` varchar(1026) DEFAULT NULL,
  `height` double DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `baseHp` int(11) DEFAULT NULL,
  `baseAttack` int(11) DEFAULT NULL,
  `baseDefense` int(11) DEFAULT NULL,
  `baseSpeed` int(11) DEFAULT NULL,
  `baseSpecialAttack` int(11) DEFAULT NULL,
  `baseSpecialDefense` int(11) DEFAULT NULL,
  `hpEV` int(11) NOT NULL DEFAULT '0',
  `attackEV` int(11) NOT NULL DEFAULT '0',
  `defenseEV` int(11) NOT NULL DEFAULT '0',
  `speedEV` int(11) NOT NULL DEFAULT '0',
  `specialAttackEV` int(11) NOT NULL DEFAULT '0',
  `specialDefenseEV` int(11) NOT NULL DEFAULT '0',
  `abilityId1` int(11) NOT NULL DEFAULT '0',
  `abilityId2` int(11) NOT NULL DEFAULT '0',
  `abilityId3` int(11) NOT NULL DEFAULT '0',
  `catchRate` int(11) NOT NULL DEFAULT '0',
  `habitat` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)
-- Tabel structuur die we kunnen gebruiken voor de pokemon (VOORBEELD)