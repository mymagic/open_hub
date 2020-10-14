## 0.6.343
- completed #9 detach authentication & authorization from MaGIC connect
- fixed #28 embed code need longer char length than 32 chars
- completed #38 [f7] add tabular field 
- added audit trail for default functionality like admin, member, organization, individual, country, state, city, cluster, industry, impact, legalForm, persona, sdg, startupStage, embed, event, eventGroup, eventOwner, milestone
- added classification master data to organization
- added #40: in backend, member page has individual tab displaying how many individual profile linked to a specific member
- added #41: in backend, member page has organization tab displaying how many organization profile linked to a specific member

## 0.5.218
- fixed #32: Saving individual model will trigger error repository() not found 
- fixed #31: cloudflare error when saving module config
- refactored lingual to an i18n module under yeebase
- updated f7 to remove hardcode survey in form

## 0.5.217
- fixed #24: ACL do not list actions of modules properly
- fixed #23: after first setup, error 'Property "Role.is_access_backend" is not defined.' show
- added #22: script can set access control which will be use in module upgrade/system migration
- fixed #18: Remove hardcoded content out from cpanel terminate account
- fixed #17: Join existing company js bug
- fixed #14: resource check on owner is not done properly
- fixed #13: resource module view in member control panel with long title caused margin issue in layout
- updated YsUtil composer package

## 0.5.216
- [openHub] added upgrade functions 
- fixed #18: Remove hardcoded content out from cpanel terminate account
- fixed #17: Join existing company js bug bug ui glitch
- fixed #14: resource check on owner is not done properly
- fixed #13: resource module view in member control panel with long title caused margin issue in layout
- fixed #11: bug at delete existing organization
- fixed #10: bug at join existing organization in cpanel