ALTER TABLE `{$p}emailtemplate_config` 
	CHANGE `emailtemplate_config_shadow_top` `emailtemplate_config_shadow_top` TEXT NOT NULL, 
	CHANGE `emailtemplate_config_shadow_left` `emailtemplate_config_shadow_left` TEXT NOT NULL, 
	CHANGE `emailtemplate_config_shadow_right` `emailtemplate_config_shadow_right` TEXT NOT NULL, 
	CHANGE `emailtemplate_config_shadow_bottom` `emailtemplate_config_shadow_bottom` TEXT NOT NULL;
	
UPDATE `{$p}emailtemplate_config` SET 
	`emailtemplate_config_shadow_top` = 'YTo2OntzOjY6Imxlbmd0aCI7czowOiIiO3M6Nzoib3ZlcmxhcCI7czowOiIiO3M6NToic3RhcnQiO3M6MDoiIjtzOjM6ImVuZCI7czowOiIiO3M6ODoibGVmdF9pbWciO3M6MDoiIjtzOjk6InJpZ2h0X2ltZyI7czowOiIiO30=', 
	`emailtemplate_config_shadow_left` = 'YTo0OntzOjY6Imxlbmd0aCI7czoxOiI5IjtzOjc6Im92ZXJsYXAiO3M6MToiOCI7czo1OiJzdGFydCI7czo3OiIjZjhmOGY4IjtzOjM6ImVuZCI7czo3OiIjZDRkNGQ0Ijt9', 
	`emailtemplate_config_shadow_right` = 'YTo0OntzOjY6Imxlbmd0aCI7czoxOiI5IjtzOjc6Im92ZXJsYXAiO3M6MToiOCI7czo1OiJzdGFydCI7czo3OiIjZDRkNGQ0IjtzOjM6ImVuZCI7czo3OiIjZjhmOGY4Ijt9', 
	`emailtemplate_config_shadow_bottom` = 'YTo2OntzOjY6Imxlbmd0aCI7czoxOiI5IjtzOjc6Im92ZXJsYXAiO3M6MToiOCI7czo1OiJzdGFydCI7czo3OiIjZDRkNGQ0IjtzOjM6ImVuZCI7czo3OiIjZjhmOGY4IjtzOjg6ImxlZnRfaW1nIjtzOjM5OiJkYXRhL2VtYWlsdGVtcGxhdGUvZ3JheS9ib3R0b21fbGVmdC5wbmciO3M6OToicmlnaHRfaW1nIjtzOjQwOiJkYXRhL2VtYWlsdGVtcGxhdGUvZ3JheS9ib3R0b21fcmlnaHQucG5nIjt9' 
WHERE `emailtemplate_config_shadow_top` LIKE 'a:6:{%';