UPDATE `{$p}emailtemplate`  
   SET `emailtemplate_vqmod` = '';

UPDATE `{$p}emailtemplate`  
   SET `emailtemplate_template` = '' 
 WHERE `emailtemplate_default` = 1 AND `emailtemplate_key` = 'information.contact';