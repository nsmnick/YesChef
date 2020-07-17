#
# SQL Export
# Created by Querious (201069)
# Created: 13 May 2020 at 15:50:05 BST
# Encoding: Unicode (UTF-8)
#


SET @PREVIOUS_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS;
SET FOREIGN_KEY_CHECKS = 0;


DROP TABLE IF EXISTS `tbl_projects_checklist_repeating_values`;


CREATE TABLE `tbl_projects_checklist_repeating_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `checklist_values_id` int(10) unsigned DEFAULT '0',
  `last_modified_by_id` int(128) unsigned DEFAULT '0',
  `last_modified_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `last_modified_by_id` (`last_modified_by_id`),
  KEY `checklist_values_id` (`checklist_values_id`),
  CONSTRAINT `tbl_projects_checklist_repeating_values_ibfk_3` FOREIGN KEY (`last_modified_by_id`) REFERENCES `tbl_users` (`id`),
  CONSTRAINT `tbl_projects_checklist_repeating_values_ibfk_4` FOREIGN KEY (`checklist_values_id`) REFERENCES `tbl_projects_checklist_values` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;




SET FOREIGN_KEY_CHECKS = @PREVIOUS_FOREIGN_KEY_CHECKS;


SET @PREVIOUS_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS;
SET FOREIGN_KEY_CHECKS = 0;


LOCK TABLES `tbl_projects_checklist_repeating_values` WRITE;
ALTER TABLE `tbl_projects_checklist_repeating_values` DISABLE KEYS;
INSERT INTO `tbl_projects_checklist_repeating_values` (`id`, `checklist_values_id`, `last_modified_by_id`, `last_modified_date`) VALUES 
	(12,7457,1,'2020-05-04 17:04:36'),
	(13,7457,1,'2020-05-04 17:05:11'),
	(14,7457,1,'2020-05-04 17:05:29');
ALTER TABLE `tbl_projects_checklist_repeating_values` ENABLE KEYS;
UNLOCK TABLES;




SET FOREIGN_KEY_CHECKS = @PREVIOUS_FOREIGN_KEY_CHECKS;


